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
}
