<?php

namespace App\Entity;

use App\Repository\HthcardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HthcardRepository::class)]
class Hthcard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $manacost = null;

    #[ORM\Column]
    private ?bool $isminion = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getManacost(): ?int
    {
        return $this->manacost;
    }

    public function setManacost(int $manacost): static
    {
        $this->manacost = $manacost;

        return $this;
    }

    public function isIsminion(): ?bool
    {
        return $this->isminion;
    }

    public function setIsminion(bool $isminion): static
    {
        $this->isminion = $isminion;

        return $this;
    }
}
