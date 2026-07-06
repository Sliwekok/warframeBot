<?php

    namespace App\Entity;

    use App\Repository\RivenAttributeRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(repositoryClass: RivenAttributeRepository::class)]
    class RivenAttribute
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\ManyToOne(inversedBy: 'attributes')]
        #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
        private ?Riven $riven = null;

        #[ORM\Column(length: 255)]
        private ?string $name = null;

        #[ORM\Column(length: 255)]
        private ?string $value = null;

        #[ORM\Column(length: 20)]
        private ?string $type = null; // "positive" | "negative"

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getRiven(): ?Riven
        {
            return $this->riven;
        }

        public function setRiven(?Riven $riven): static
        {
            $this->riven = $riven;
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

        public function getValue(): ?string
        {
            return $this->value;
        }

        public function setValue(string $value): static
        {
            $this->value = $value;
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
    }
