<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ItemTradableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemTradableRepository::class)]
#[ORM\Table(name: 'items_tradable')]
#[ORM\HasLifecycleCallbacks]
class ItemTradable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * External item ID from Warframe Market/API
     */
    #[ORM\Column(name: 'external_id', length: 100, unique: true)]
    public string $externalId;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(length: 255, unique: true)]
    public string $slug;

    #[ORM\Column]
    public bool $vaulted = false;

    #[ORM\Column]
    public bool $tradable = false;


    /**
     * Tags stored as JSON array
     */
    #[ORM\Column(type: Types::JSON)]
    public array $tags = [];

    /**
     * Parent item (for set parts)
     */
    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    public ?self $parent = null;

    #[ORM\Column(name: 'created_at')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(length: 4000, nullable: true)]
    public ?string $wiki_link = null;

    #[ORM\Column(length: 4000, nullable: true)]
    public ?string $description = null;

    #[ORM\Column(length: 4000, nullable: true)]
    public ?string $icon = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();

        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isVaulted(): bool
    {
        return $this->vaulted;
    }

    public function setVaulted(bool $vaulted): self
    {
        $this->vaulted = $vaulted;

        return $this;
    }

    public function isTradable(): bool
    {
        return $this->tradable;
    }

    public function setTradable(bool $tradable): self
    {
        $this->tradable = $tradable;

        return $this;
    }


    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getWikiLink(): ?string
    {
        return $this->wiki_link;
    }

    public function setWikiLink(?string $wiki_link): static
    {
        $this->wiki_link = $wiki_link;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }
}
