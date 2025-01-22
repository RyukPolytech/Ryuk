<?php

namespace App\Service;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataGenerator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importDataFromCSV (): void
    {
        $countryFilePath = "Assets\dataFiles\country_stats";

        $countrySpreadsheet = IOFactory::load($countryFilePath);
        $countrySheet = $countrySpreadsheet->getActiveSheet();
        $rows = $countrySheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index <= 4) {
                continue; // Skip header row
            }
            if ($row[1] === "") {
                continue;
            }

            $entity = new Country();
            $entity->setName($row[0]);
            $entity->setManLifeExpectancy($row[1]);
            $entity->setWomanLifeExpectancy($row[2]);
            $entity->setMortalityRate($row[3]);

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

}