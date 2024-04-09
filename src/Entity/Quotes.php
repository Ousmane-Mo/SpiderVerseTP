<?php

namespace App\Entity;

use App\Repository\QuotesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotesRepository::class)
 */
class Quotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $quote;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characters;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getCharacters(): ?Users
    {
        return $this->characters;
    }

    public function setCharacters(?Users $characters): self
    {
        $this->characters = $characters;

        return $this;
    }
}
