<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $dep_number = null;

    #[ORM\Column]
    private ?float $avg_death_day = null;

    #[ORM\ManyToOne(inversedBy: 'departments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDepNumber(): ?int
    {
        return $this->dep_number;
    }

    public function setDepNumber(int $dep_number): static
    {
        $this->dep_number = $dep_number;

        return $this;
    }

    public function getAvgDeathDay(): ?float
    {
        return $this->avg_death_day;
    }

    public function setAvgDeathDay(float $avg_death_day): static
    {
        $this->avg_death_day = $avg_death_day;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }
}
