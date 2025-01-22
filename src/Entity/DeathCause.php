<?php

namespace App\Entity;

use App\Repository\DeathCauseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeathCauseRepository::class)]
class DeathCause
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(nullable: true)]
    private ?int $man_death = null;

    #[ORM\Column(nullable: true)]
    private ?int $woman_death = null;

    #[ORM\Column]
    private ?int $year = null;

    /**
     * @var Collection<int, Death>
     */
    #[ORM\OneToMany(targetEntity: Death::class, mappedBy: 'deathcause')]
    private Collection $deaths;

    #[ORM\Column]
    private ?int $span_0_to_64 = null;

    #[ORM\Column]
    private ?int $span_65_to_85 = null;

    #[ORM\Column(nullable: true)]
    private ?int $span_85_plus = null;

    #[ORM\Column]
    private ?int $totalDeath = null;

    public function __construct()
    {
        $this->deaths = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getManDeath(): ?int
    {
        return $this->man_death;
    }

    public function setManDeath(?int $man_death): static
    {
        $this->man_death = $man_death;

        return $this;
    }

    public function getWomanDeath(): ?int
    {
        return $this->woman_death;
    }

    public function setWomanDeath(?int $woman_death): static
    {
        $this->woman_death = $woman_death;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

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
            $death->setDeathcause($this);
        }

        return $this;
    }

    public function removeDeath(Death $death): static
    {
        if ($this->deaths->removeElement($death)) {
            // set the owning side to null (unless already changed)
            if ($death->getDeathcause() === $this) {
                $death->setDeathcause(null);
            }
        }

        return $this;
    }

    public function getSpan0To64(): ?int
    {
        return $this->span_0_to_64;
    }

    public function setSpan0To64(int $span_0_to_64): static
    {
        $this->span_0_to_64 = $span_0_to_64;

        return $this;
    }

    public function getSpan65To85(): ?int
    {
        return $this->span_65_to_85;
    }

    public function setSpan65To85(?int $span_65_to_85): static
    {
        $this->span_65_to_85 = $span_65_to_85;

        return $this;
    }

    public function getSpan85Plus(): ?int
    {
        return $this->span_85_plus;
    }

    public function setSpan85Plus(?int $span_85_plus): static
    {
        $this->span_85_plus = $span_85_plus;

        return $this;
    }

    public function getTotalDeath(): ?int
    {
        return $this->totalDeath;
    }

    public function setTotalDeath(int $totalDeath): static
    {
        $this->totalDeath = $totalDeath;

        return $this;
    }
}
