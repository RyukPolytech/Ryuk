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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $sex = null;

    #[ORM\Column]
    private ?int $birthyear = null;

    #[ORM\Column]
    private ?int $birthcountry = null;

    #[ORM\Column(nullable: true)]
    private ?int $deathcountry = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(nullable: true)]
    private ?int $deathcause = null;

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

    public function getSex(): ?int
    {
        return $this->sex;
    }

    public function setSex(?int $sex): static
    {
        $this->sex = $sex;

        return $this;
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

    public function getBirthcountry(): ?int
    {
        return $this->birthcountry;
    }

    public function setBirthcountry(int $birthcountry): static
    {
        $this->birthcountry = $birthcountry;

        return $this;
    }

    public function getDeathcountry(): ?int
    {
        return $this->deathcountry;
    }

    public function setDeathcountry(?int $deathcountry): static
    {
        $this->deathcountry = $deathcountry;

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

    public function getDeathcause(): ?int
    {
        return $this->deathcause;
    }

    public function setDeathcause(?int $deathcause): static
    {
        $this->deathcause = $deathcause;

        return $this;
    }
}
