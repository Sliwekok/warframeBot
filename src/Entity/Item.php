<?php

    namespace App\Entity;

    use App\Repository\ItemRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(repositoryClass: ItemRepository::class)]
    class Item
    {
        public function __construct()
        {
            $now = new \DateTimeImmutable();

            $this->createdAt = $now;
            $this->updatedAt = $now;
        }
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        public ?int $id = null {
            get {
                return $this->id;
            }
        }

        #[ORM\Column]
        private ?int $login_id = null;

        #[ORM\Column]
        private ?int $price = null;

        #[ORM\Column]
        private ?int $platform_id = null;

        #[ORM\ManyToOne(targetEntity: ItemTradable::class)]
        #[ORM\JoinColumn(nullable: false, name: 'item_id')]
        private ?ItemTradable $item = null;

        #[ORM\Column(length: 255)]
        private ?string $type = null;

        #[ORM\Column(length: 255)]
        private ?string $status = null;

        #[ORM\Column]
        private ?\DateTimeImmutable $createdAt = null;

        #[ORM\Column]
        private ?\DateTimeImmutable $updatedAt = null;

        public function getLoginId(): ?int
        {
            return $this->login_id;
        }

        public function setLoginId(int $loginId): static
        {
            $this->login_id = $loginId;

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

        public function getPlatformId(): ?int
        {
            return $this->platform_id;
        }

        public function setPlatformId(int $platformId): static
        {
            $this->platform_id = $platformId;

            return $this;
        }

        public function getItem(): ?ItemTradable
        {
            return $this->item;
        }

        public function setItem(?ItemTradable $item): static
        {
            $this->item = $item;

            return $this;
        }

        public function getType(): ?string
        {
            return $this->type;
        }

        public function setType(string $type): static
        {
            $this->type = $type;

            return $this;
        }

        public function getStatus(): ?string
        {
            return $this->status;
        }

        public function setStatus(string $status): static
        {
            $this->status = $status;

            return $this;
        }

        public function getCreatedAt(): ?\DateTimeImmutable
        {
            return $this->createdAt;
        }

        public function setCreatedAt(\DateTimeImmutable $createdAt): static
        {
            $this->createdAt = $createdAt;

            return $this;
        }

        public function getUpdatedAt(): ?\DateTimeImmutable
        {
            return $this->updatedAt;
        }

        public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
        {
            $this->updatedAt = $updatedAt;

            return $this;
        }
    }
