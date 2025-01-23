<?php

namespace App\Entity;

use App\Repository\DeathRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeathRepository::class)]
class Death
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $birthyear = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $birthcountry = null;

    #[ORM\ManyToOne(inversedBy: 'deaths')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $deathcountry = null;

    #[ORM\ManyToOne(inversedBy: 'deaths')]
    #[ORM\JoinColumn(nullable: true)]
    private ?DeathCause $deathcause = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $sex = null;

    #[ORM\Column]
    private ?int $death_year = null;

    #[ORM\ManyToOne(inversedBy: 'deaths')]
    private ?Department $death_department = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthyear(): ?int
    {
        return $this->birthyear;
    }

    public function setBirthyear(int $birthyear): static
    {
        $this->birthyear = $birthyear;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getBirthcountry(): ?Country
    {
        return $this->birthcountry;
    }

    public function setBirthcountry(?Country $birthcountry): static
    {
        $this->birthcountry = $birthcountry;

        return $this;
    }

    public function getDeathcountry(): ?Country
    {
        return $this->deathcountry;
    }

    public function setDeathcountry(?Country $deathcountry): static
    {
        $this->deathcountry = $deathcountry;

        return $this;
    }

    public function getDeathcause(): ?DeathCause
    {
        return $this->deathcause;
    }

    public function setDeathcause(?DeathCause $deathcause): static
    {
        $this->deathcause = $deathcause;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getDeathYear(): ?int
    {
        return $this->death_year;
    }

    public function setDeathYear(int $death_year): static
    {
        $this->death_year = $death_year;

        return $this;
    }

    public function getDeathDepartment(): ?Department
    {
        return $this->death_department;
    }

    public function setDeathDepartment(?Department $death_department): static
    {
        $this->death_department = $death_department;

        return $this;
    }
}
