<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Department;
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
        // Recherche de la France
        $france = $this->entityManager->getRepository(Country::class)->findOneBy([
            'name' => "France",
        ]);

        if (!$france) {
            throw new \Exception("Le pays 'France' n'existe pas dans la base de données.");
        }

        // Chargement des départements
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
            throw new \Exception("pb flush");
        }
    }
}
