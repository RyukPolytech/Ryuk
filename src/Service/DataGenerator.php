<?php

namespace App\Service;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataGenerator
{
    private EntityManagerInterface $entityManager;
    private string $rootPath;

    public function __construct(string $rootPath, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rootPath = $rootPath;
    }

    public function importDataFromCSV(): void
    {
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

        $this->entityManager->flush();
    }
}
