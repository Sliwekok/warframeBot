<?php

namespace App\Entity;

use App\Repository\RivenAttributeExternalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RivenAttributeExternalRepository::class)]
class RivenAttributeExternal
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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $exclusive_to = [];

    #[ORM\Column(nullable: true)]
    private ?bool $positiveIsNegative = null;

    #[ORM\Column(nullable: true)]
    private ?bool $positiveOnly = null;

    #[ORM\Column(nullable: true)]
    private ?bool $negativeOnly = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\Column(length: 255)]
    private ?string $external_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getExclusiveTo(): array
    {
        return $this->exclusive_to;
    }

    public function setExclusiveTo(array $exclusive_to): static
    {
        $this->exclusive_to = $exclusive_to;

        return $this;
    }

    public function isPositiveIsNegative(): ?bool
    {
        return $this->positiveIsNegative;
    }

    public function setPositiveIsNegative(?bool $positiveIsNegative): static
    {
        $this->positiveIsNegative = $positiveIsNegative;

        return $this;
    }

    public function isPositiveOnly(): ?bool
    {
        return $this->positiveOnly;
    }

    public function setPositiveOnly(?bool $positiveOnly): static
    {
        $this->positiveOnly = $positiveOnly;

        return $this;
    }

    public function isNegativeOnly(): ?bool
    {
        return $this->negativeOnly;
    }

    public function setNegativeOnly(?bool $negativeOnly): static
    {
        $this->negativeOnly = $negativeOnly;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): static
    {
        $this->external_id = $external_id;

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
