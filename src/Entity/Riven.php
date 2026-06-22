<?php

namespace App\Entity;

use App\Repository\RivenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RivenRepository::class)]
class Riven
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rivens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Login $login = null;

    #[ORM\Column(length: 255)]
    private ?string $weapon_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attr_pos_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attr_pos_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attr_pos_3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attr_neg = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $image_url = null;

    #[ORM\Column(length: 255)]
    private ?string $wiki_url = null;

    #[ORM\Column(length: 255)]
    private ?string $name_curl = null;

    #[ORM\OneToMany(mappedBy: 'riven_id', targetEntity: Notifications::class)]
    private Collection $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?Login
    {
        return $this->login;
    }

    public function setLogin(?Login $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getWeaponName(): ?string
    {
        return $this->weapon_name;
    }

    public function setWeaponName(string $weapon_name): static
    {
        $this->weapon_name = $weapon_name;

        return $this;
    }

    public function getAttrPos1(): ?string
    {
        return $this->attr_pos_1;
    }

    public function setAttrPos1(?string $attr_pos_1): static
    {
        $this->attr_pos_1 = $attr_pos_1;

        return $this;
    }

    public function getAttrPos2(): ?string
    {
        return $this->attr_pos_2;
    }

    public function setAttrPos2(?string $attr_pos_2): static
    {
        $this->attr_pos_2 = $attr_pos_2;

        return $this;
    }

    public function getAttrPos3(): ?string
    {
        return $this->attr_pos_3;
    }

    public function setAttrPos3(?string $attr_pos_3): static
    {
        $this->attr_pos_3 = $attr_pos_3;

        return $this;
    }

    public function getAttrNeg(): ?string
    {
        return $this->attr_neg;
    }

    public function setAttrNeg(?string $attr_neg): static
    {
        $this->attr_neg = $attr_neg;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): static
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getWikiUrl(): ?string
    {
        return $this->wiki_url;
    }

    public function setWikiUrl(string $wiki_url): static
    {
        $this->wiki_url = $wiki_url;

        return $this;
    }

    public function getNameCurl(): ?string
    {
        return $this->name_curl;
    }

    public function setNameCurl(string $name_curl): static
    {
        $this->name_curl = $name_curl;

        return $this;
    }

    /**
     * @return Collection<int, Notifications>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notifications $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setRivenId($this);
        }

        return $this;
    }

    public function removeNotification(Notifications $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getRivenId() === $this) {
                $notification->setRivenId(null);
            }
        }

        return $this;
    }

    public function hasAnyAttribute(): bool {
        $attrExists = false;

        if ($this->getAttrPos1() != null) $attrExists = true;
        if ($this->getAttrPos2() != null) $attrExists = true;
        if ($this->getAttrPos3() != null) $attrExists = true;
        if ($this->getAttrNeg() != null) $attrExists = true;

        return $attrExists;
    }
}
