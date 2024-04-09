<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoviesRepository::class)
 */
class Movies
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moviename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $yearreleased;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="movies")
     */
    private $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoviename(): ?string
    {
        return $this->moviename;
    }

    public function setMoviename(string $moviename): self
    {
        $this->moviename = $moviename;

        return $this;
    }

    public function getYearreleased(): ?string
    {
        return $this->yearreleased;
    }

    public function setYearreleased(string $yearreleased): self
    {
        $this->yearreleased = $yearreleased;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Users $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
        }

        return $this;
    }

    public function removeCharacter(Users $character): self
    {
        $this->characters->removeElement($character);

        return $this;
    }
}
