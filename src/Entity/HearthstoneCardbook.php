<?php

namespace App\Entity;

use App\Entity\Hthcard;
use App\Entity\Member;
use App\Repository\HearthstoneCardbookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HearthstoneCardbookRepository::class)]
class HearthstoneCardbook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'hearthstoneCardbook', targetEntity: Hthcard::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $cards;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'hearthstoneCardbooks', targetEntity: Member::class)]
    private ?member $member = null;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Hthcard>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Hthcard $card): static
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setHearthstoneCardbook($this);
        }

        return $this;
    }

    public function removeCard(Hthcard $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getHearthstoneCardbook() === $this) {
                $card->setHearthstoneCardbook(null);
            }
        }

        return $this;
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

    public function getMember(): ?member
    {
        return $this->member;
    }

    public function setMember(?member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
