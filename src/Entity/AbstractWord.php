<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class AbstractWord {

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nameStressed;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $nameBroken;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nameCondensed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $corpusCount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $corpusPercent;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $corpusRank;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameStressed(): ?string
    {
        return $this->nameStressed;
    }

    public function setNameStressed(?string $nameStressed): self
    {
        $this->nameStressed = $nameStressed;

        return $this;
    }

    public function getNameBroken(): ?string
    {
        return $this->nameBroken;
    }

    public function setNameBroken(?string $nameBroken): self
    {
        $this->nameBroken = $nameBroken;

        return $this;
    }

    public function getNameCondensed(): ?string
    {
        return $this->nameCondensed;
    }

    public function setNameCondensed(string $nameCondensed): self
    {
        $this->nameCondensed = $nameCondensed;

        return $this;
    }

    public function getCorpusCount(): ?int
    {
        return $this->corpusCount;
    }

    public function setCorpusCount(?int $corpusCount): self
    {
        $this->corpusCount = $corpusCount;

        return $this;
    }

    public function getCorpusPercent(): ?float
    {
        return $this->corpusPercent;
    }

    public function setCorpusPercent(?float $corpusPercent): self
    {
        $this->corpusPercent = $corpusPercent;

        return $this;
    }

    public function getCorpusRank(): ?int
    {
        return $this->corpusRank;
    }

    public function setCorpusRank(?int $corpusRank): self
    {
        $this->corpusRank = $corpusRank;

        return $this;
    }
}
