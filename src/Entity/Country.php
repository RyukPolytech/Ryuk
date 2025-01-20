<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $mortality_rate = null;

    #[ORM\Column(nullable: true)]
    private ?float $man_life_expectancy = null;

    #[ORM\Column(nullable: true)]
    private ?float $woman_life_expectancy = null;

    /**
     * @var Collection<int, Death>
     */
    #[ORM\OneToMany(targetEntity: Death::class, mappedBy: 'deathcountry')]
    private Collection $deaths;

    /**
     * @var Collection<int, Department>
     */
    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'country', orphanRemoval: true)]
    private Collection $departments;

    public function __construct()
    {
        $this->deaths = new ArrayCollection();
        $this->departments = new ArrayCollection();
    }

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

    public function getMortalityRate(): ?float
    {
        return $this->mortality_rate;
    }

    public function setMortalityRate(?float $mortality_rate): static
    {
        $this->mortality_rate = $mortality_rate;

        return $this;
    }

    public function getManLifeExpectancy(): ?float
    {
        return $this->man_life_expectancy;
    }

    public function setManLifeExpectancy(?float $man_life_expectancy): static
    {
        $this->man_life_expectancy = $man_life_expectancy;

        return $this;
    }

    public function getWomanLifeExpectancy(): ?float
    {
        return $this->woman_life_expectancy;
    }

    public function setWomanLifeExpectancy(?float $woman_life_expectancy): static
    {
        $this->woman_life_expectancy = $woman_life_expectancy;

        return $this;
    }

    /**
     * @return Collection<int, Death>
     */
    public function getDeaths(): Collection
    {
        return $this->deaths;
    }

    public function addDeath(Death $death): static
    {
        if (!$this->deaths->contains($death)) {
            $this->deaths->add($death);
            $death->setDeathcountry($this);
        }

        return $this;
    }

    public function removeDeath(Death $death): static
    {
        if ($this->deaths->removeElement($death)) {
            // set the owning side to null (unless already changed)
            if ($death->getDeathcountry() === $this) {
                $death->setdeathcountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): static
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setCountry($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): static
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getCountry() === $this) {
                $department->setCountry(null);
            }
        }

        return $this;
    }
}
