<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\Country;
use App\Entity\Death;
use App\Entity\DeathCause;
use App\Entity\Department;
use App\Repository\CountryRepository;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AllowDynamicProperties] class DataGenerator
{
    private EntityManagerInterface $entityManager;
    private ?CountryRepository $countryRepo = null;
    private ?DepartmentRepository $departmentRepo = null;
    private HttpClientInterface $httpClient;
    private $nbDeathFile;
    private string $rootPath;

    public function __construct(string $rootPath, string $nbDeathFile, EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->rootPath = $rootPath;
        $this->httpClient = $httpClient;
        $this->nbDeathFile = (int) $nbDeathFile;
    }

    /**
     * @throws \Exception
     */
    public function importDataFromCSV(): void
    {
        //####################
        // Chargement des pays
        //####################
        $countryFilePath = $this->rootPath . '/assets/dataFiles/country_stats.csv';

        if (!file_exists($countryFilePath)) {
            throw new \Exception("Le fichier n'existe pas : $countryFilePath");
        }

        $countrySpreadsheet = IOFactory::load($countryFilePath);
        $countrySheet = $countrySpreadsheet->getActiveSheet();
        $rows = $countrySheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index <= 4) {
                continue; // Skip header row
            }

            if ((float) $row[1] === 0.0) {
                continue;
            }

            // Recherche une entité existante avec le même nom
            $existingCountry = $this->entityManager->getRepository(Country::class)->findOneBy([
                'name' => $row[0],
            ]);

            if ($existingCountry) {
                // Vérifie si les autres attributs ont changé
                if (
                    $existingCountry->getManLifeExpectancy()   !== (float) $row[1] ||
                    $existingCountry->getWomanLifeExpectancy() !== (float) $row[2] ||
                    $existingCountry->getMortalityRate()       !== (float) $row[4]
                ) {
                    // Met à jour les attributs
                    $existingCountry->setManLifeExpectancy((float) $row[1]);
                    $existingCountry->setWomanLifeExpectancy((float) $row[2]);
                    $existingCountry->setMortalityRate((float) $row[4]);

                    $this->entityManager->persist($existingCountry); // Enregistre les modifications
                }
            } else {
                // Crée une nouvelle entité si elle n'existe pas
                $entity = new Country();
                $entity->setName($row[0]);
                $entity->setManLifeExpectancy((float) $row[1]);
                $entity->setWomanLifeExpectancy((float) $row[2]);
                $entity->setMortalityRate((float) $row[4]);

                $this->entityManager->persist($entity);
            }
        }

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("flush issue for countries");
        }


        // Recherche de la France
        $france = $this->entityManager->getRepository(Country::class)->findOneBy([
            'name' => "France",
        ]);

        if (!$france) {
            throw new \Exception("Le pays 'France' n'existe pas dans la base de données.");
        }

        //############################
        // Chargement des départements
        //############################
        $departmentFilePath = $this->rootPath . '/assets/dataFiles/departments.csv';

        if (!file_exists($departmentFilePath)) {
            throw new \Exception("Le fichier n'existe pas : $departmentFilePath");
        }

        $departmentSpreadsheet = IOFactory::load($departmentFilePath);
        $departmentSheet = $departmentSpreadsheet->getActiveSheet();
        $rows = $departmentSheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Skip header row
            }

            if ((int) $row[0] === 0) {
                continue;
            }

            $existingDepartment = $this->entityManager->getRepository(Department::class)->findOneBy([
                'name' => $row[1],
            ]);

            if (!$existingDepartment) {
                $entity = new Department();
                $entity->setName($row[1]);
                $entity->setDepNumber((int) $row[0]);
                $entity->setCountry($france);

                $this->entityManager->persist($entity);
            }
        }

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("flush issue for departments");
        }

        //############################
        // Chargement des death causes
        //############################
        $deathCauseFilePath = $this->rootPath . '/assets/dataFiles/death_causes.csv';

        if (!file_exists($deathCauseFilePath)) {
            throw new \Exception("Le fichier n'existe pas : $deathCauseFilePath");
        }

        $deathCauseSpreadsheet = IOFactory::load($deathCauseFilePath);
        $deathCauseSheet = $deathCauseSpreadsheet->getActiveSheet();
        $rows = $deathCauseSheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index <= 2) {
                continue; // Skip header row
            }

            if ((int) $row[1] === 0) {
                continue;
            }

            $existingDeathCause = $this->entityManager->getRepository(DeathCause::class)->findOneBy([
                'title' => $row[0],
            ]);

            if (!$existingDeathCause) {
                $womanDeath = (int) $row[5];
                $manDeath   = (int) $row[9];
                $totalDeath = $womanDeath + $manDeath;

                $entity = new DeathCause();
                $entity->setTitle($row[0]);
                $entity->setWomanDeath($womanDeath);
                $entity->setManDeath($manDeath);
                $entity->setSpan0To64($row[13]);
                $entity->setSpan65To85((int) $row[16]);
                $entity->setSpan85Plus((int) $row[19]);
                $entity->setTotalDeath($totalDeath);
                $entity->setYear(2022);

                $this->entityManager->persist($entity);
            }
        }

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("flush issue for death causes");
        }

        //#####################
        // Chargement des décès
        //#####################

        $this->countryRepo    = $this->entityManager->getRepository(Country::class);
        $this->departmentRepo = $this->entityManager->getRepository(Department::class);
        $france = $this->countryRepo->findOneBy(['name' => 'France']);

        for ($i = 0; $i < $this->nbDeathFile; $i++) {

            $deathsFilePath = $this->rootPath . '/assets/dataFiles/deathlist_part_' . $i . '.csv';

            if (!file_exists($deathsFilePath)) {
                throw new \Exception("Le fichier n'existe pas : $deathsFilePath");
            }

            $deathsSpreadsheet = IOFactory::load($deathsFilePath);
            $deathsSheet = $deathsSpreadsheet->getActiveSheet();
            $rows = $deathsSheet->toArray();

            foreach ($rows as $index => $row) {
                if ($index <= 1) {
                    continue; // Skip header row
                }

                $lastName = $row[0];
                $firstName = explode(" ", $row[1])[0];
                $birthDate = $row[3];
                $deathDate = $row[4];

                $existingDeath = $this->entityManager->getRepository(Death::class)->findOneBy([
                    'last_name' => $lastName,
                    'first_name' => $firstName,
                ]);

                if (!$existingDeath) {
                    $entity = new Death();
                    $entity->setLastName($lastName);
                    $entity->setFirstName($firstName);
                    $entity->setSex($row[2]);

                    $birthYear = (int)explode("-", $birthDate)[0];
                    $deathYear = (int)explode("-", $deathDate)[0];
                    $entity->setBirthYear($birthYear);
                    $entity->setDeathYear($deathYear);
                    $entity->setAge($deathYear - $birthYear);


                    $entity->setBirthCountry($france);
                    $entity->setDeathCountry($france);

                    $deathDepartment = $this->departmentRepo->findOneBy(['dep_number' => $row[16]]);
                    $entity->setDeathDepartment($deathDepartment);

                    $this->entityManager->persist($entity);
                }
            }
            $this->entityManager->flush();
        }
    }
}
