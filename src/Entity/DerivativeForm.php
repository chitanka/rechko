<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DerivativeFormRepository")
 */
class DerivativeForm extends AbstractWord {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInfinitive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Word", inversedBy="derivativeForms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseWord;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $searchCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsInfinitive(): ?bool
    {
        return $this->isInfinitive;
    }

    public function setIsInfinitive(bool $isInfinitive): self
    {
        $this->isInfinitive = $isInfinitive;

        return $this;
    }

    public function getBaseWord(): ?Word
    {
        return $this->baseWord;
    }

    public function setBaseWord(?Word $baseWord): self
    {
        $this->baseWord = $baseWord;

        return $this;
    }

    public function getSearchCount(): ?int
    {
        return $this->searchCount;
    }

    public function setSearchCount(?int $searchCount): self
    {
        $this->searchCount = $searchCount;

        return $this;
    }
}
