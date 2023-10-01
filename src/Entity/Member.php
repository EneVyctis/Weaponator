<?php

namespace App\Entity;

use App\Entity\Wardrobe;
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
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: wardrobe::class)]
    private Collection $wardrobe;

    public function __construct()
    {
        $this->wardrobe = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Collection<int, wardrobe>
     */
    public function getWardrobe(): Collection
    {
        return $this->wardrobe;
    }

    public function addWardrobe(wardrobe $wardrobe): static
    {
        if (!$this->wardrobe->contains($wardrobe)) {
            $this->wardrobe->add($wardrobe);
            $wardrobe->setOwner($this);
        }

        return $this;
    }

    public function removeWardrobe(wardrobe $wardrobe): static
    {
        if ($this->wardrobe->removeElement($wardrobe)) {
            // set the owning side to null (unless already changed)
            if ($wardrobe->getOwner() === $this) {
                $wardrobe->setOwner(null);
            }
        }

        return $this;
    }
}