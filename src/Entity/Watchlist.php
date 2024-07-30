<?php

namespace App\Entity;

use App\Repository\WatchlistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchlistRepository::class)]
#[ORM\Table(name: 'items_on_watchlist')]
class Watchlist
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $login_id = null;

    #[ORM\Column(length: 255)]
    private ?string $platform_name = null;

    #[ORM\Column(length: 255)]
    private ?string $wiki_url = null;

    #[ORM\Column(length: 255)]
    private ?string $image_url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getLoginId(): ?int
    {
        return $this->login_id;
    }

    public function getPlatformName(): ?string
    {
        return $this->platform_name;
    }

    public function getWikiUrl(): ?string
    {
        return $this->wiki_url;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }
}
