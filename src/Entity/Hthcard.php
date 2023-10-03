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

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $manacost = null;

    #[ORM\Column]
    private ?bool $isminion = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    
    private ?HearthstoneCardbook $hearthstoneCardbook = null;


    public function __toString(){
        return $this->name;
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

    public function getHearthstoneCardbook(): ?HearthstoneCardbook
    {
        return $this->hearthstoneCardbook;
    }

    public function setHearthstoneCardbook(?HearthstoneCardbook $hearthstoneCardbook): static
    {
        $this->hearthstoneCardbook = $hearthstoneCardbook;

        return $this;
    }
}
