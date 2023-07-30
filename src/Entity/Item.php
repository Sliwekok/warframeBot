<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $login_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $platform_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginId(): ?int
    {
        return $this->login_id;
    }

    public function setLoginId(int $login_id): static
    {
        $this->login_id = $login_id;

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

    public function setPlatformId(int $platform_id): static
    {
        $this->platform_id = $platform_id;

        return $this;
    }
}
