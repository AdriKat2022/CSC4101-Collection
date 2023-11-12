<?php

namespace App\Entity;

use App\Entity\HearthstoneCardbook;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: HearthstoneCardbook::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $hearthstoneCardbooks;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Deck::class, orphanRemoval: true)]
    private Collection $decks;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->hearthstoneCardbooks = new ArrayCollection();
        $this->decks = new ArrayCollection();
    }


    public function __toString(){
        return $this->nom;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    /**
     * @return Collection<int, HearthstoneCardbook>
     */
    public function getHearthstoneCardbooks(): Collection
    {
        return $this->hearthstoneCardbooks;
    }

    public function addHearthstoneCardbook(HearthstoneCardbook $hearthstoneCardbook): static
    {
        if (!$this->hearthstoneCardbooks->contains($hearthstoneCardbook)) {
            $this->hearthstoneCardbooks->add($hearthstoneCardbook);
            $hearthstoneCardbook->setMember($this);
        }

        return $this;
    }

    public function removeHearthstoneCardbook(HearthstoneCardbook $hearthstoneCardbook): static
    {
        if ($this->hearthstoneCardbooks->removeElement($hearthstoneCardbook)) {
            // set the owning side to null (unless already changed)
            if ($hearthstoneCardbook->getMember() === $this) {
                $hearthstoneCardbook->setMember(null);
            }
        }

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
            $deck->setMember($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): static
    {
        if ($this->decks->removeElement($deck)) {
            // set the owning side to null (unless already changed)
            if ($deck->getMember() === $this) {
                $deck->setMember(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMember() !== $this) {
            $user->setMember($this);
        }

        $this->user = $user;

        return $this;
    }
}
