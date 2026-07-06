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

        #[ORM\ManyToOne(inversedBy: 'riven')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Login $login = null;

        #[ORM\Column(length: 255)]
        private ?string $weaponName = null;

        #[ORM\Column]
        private ?int $price = null;

        #[ORM\Column]
        private ?int $isRead = null;

        #[ORM\OneToMany(mappedBy: 'riven', targetEntity: RivenAttribute::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
        private Collection $attributes;

        #[ORM\OneToMany(mappedBy: 'rivenId', targetEntity: Notifications::class)]
        private Collection $notifications;

        public function __construct()
        {
            $this->attributes = new ArrayCollection();
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
            return $this->weaponName;
        }

        public function setWeaponName(string $weaponName): static
        {
            $this->weaponName = $weaponName;
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

        /**
         * @return Collection<int, RivenAttribute>
         */
        public function getAttributes(): Collection
        {
            return $this->attributes;
        }

        public function addAttribute(RivenAttribute $attribute): static
        {
            if (!$this->attributes->contains($attribute)) {
                $this->attributes->add($attribute);
                $attribute->setRiven($this);
            }

            return $this;
        }

        public function removeAttribute(RivenAttribute $attribute): static
        {
            if ($this->attributes->removeElement($attribute)) {
                if ($attribute->getRiven() === $this) {
                    $attribute->setRiven(null);
                }
            }

            return $this;
        }

        public function isIsRead(): ?bool
        {
            return $this->is_read;
        }

        public function setIsRead(bool $is_read): static
        {
            $this->is_read = $is_read;

            return $this;
        }
    }
