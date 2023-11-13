<?php

namespace App\Entity;

use App\Repository\HthcardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HthcardRepository::class)]
class Hthcard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $manacost = null;

    #[ORM\Column]
    private ?bool $isminion = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: true)]
    private ?HearthstoneCardbook $hearthstoneCardbook = null;

    #[ORM\ManyToMany(targetEntity: Deck::class, mappedBy: 'cards')]
    private Collection $decks;

    public function __construct()
    {
        $this->decks = new ArrayCollection();
    }


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

    /**
     * @return Collection<int, Deck>
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    public function addDeck(Deck $deck): static
    {
        if (!$this->decks->contains($deck)) {
            $this->decks->add($deck);
            $deck->addCard($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): static
    {
        if ($this->decks->removeElement($deck)) {
            $deck->removeCard($this);
        }

        return $this;
    }
}
