<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class Word extends AbstractWord {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $meaning;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synonyms;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WordType", inversedBy="words")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $pronunciation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $etymology;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $relatedWords;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $derivedWords;

    /**
     * @ORM\Column(type="integer")
     */
    private $searchCount;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $source;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $otherLangs;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IncorrectForm", mappedBy="correctWord", orphanRemoval=true)
     */
    private $incorrectForms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DerivativeForm", mappedBy="baseWord", orphanRemoval=true)
     */
    private $derivativeForms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WordTranslation", mappedBy="word", orphanRemoval=true)
     */
    private $translations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WordRevision", mappedBy="object", orphanRemoval=true)
     */
    private $revisions;

    public function __construct()
    {
        $this->incorrectForms = new ArrayCollection();
        $this->derivativeForms = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->revisions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeaning(): ?string
    {
        return $this->meaning;
    }

    public function setMeaning(string $meaning): self
    {
        $this->meaning = $meaning;

        return $this;
    }

    public function getSynonyms(): ?string
    {
        return $this->synonyms;
    }

    public function setSynonyms(?string $synonyms): self
    {
        $this->synonyms = $synonyms;

        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getType(): ?WordType
    {
        return $this->type;
    }

    public function setType(?WordType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPronunciation(): ?string
    {
        return $this->pronunciation;
    }

    public function setPronunciation(?string $pronunciation): self
    {
        $this->pronunciation = $pronunciation;

        return $this;
    }

    public function getEtymology(): ?string
    {
        return $this->etymology;
    }

    public function setEtymology(?string $etymology): self
    {
        $this->etymology = $etymology;

        return $this;
    }

    public function getRelatedWords(): ?string
    {
        return $this->relatedWords;
    }

    public function setRelatedWords(?string $relatedWords): self
    {
        $this->relatedWords = $relatedWords;

        return $this;
    }

    public function getDerivedWords(): ?string
    {
        return $this->derivedWords;
    }

    public function setDerivedWords(?string $derivedWords): self
    {
        $this->derivedWords = $derivedWords;

        return $this;
    }

    public function getSearchCount(): int
    {
        return $this->searchCount;
    }

    public function setSearchCount(int $searchCount): self
    {
        $this->searchCount = $searchCount;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getOtherLangs(): ?string
    {
        return $this->otherLangs;
    }

    public function setOtherLangs(?string $otherLangs): self
    {
        $this->otherLangs = $otherLangs;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|IncorrectForm[]
     */
    public function getIncorrectForms(): Collection
    {
        return $this->incorrectForms;
    }

    public function addIncorrectForm(IncorrectForm $incorrectForm): self
    {
        if (!$this->incorrectForms->contains($incorrectForm)) {
            $this->incorrectForms[] = $incorrectForm;
            $incorrectForm->setCorrectWord($this);
        }

        return $this;
    }

    public function removeIncorrectForm(IncorrectForm $incorrectForm): self
    {
        if ($this->incorrectForms->contains($incorrectForm)) {
            $this->incorrectForms->removeElement($incorrectForm);
            // set the owning side to null (unless already changed)
            if ($incorrectForm->getCorrectWord() === $this) {
                $incorrectForm->setCorrectWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DerivativeForm[]
     */
    public function getDerivativeForms(): Collection
    {
        return $this->derivativeForms;
    }

    public function addDerivativeForm(DerivativeForm $derivativeForm): self
    {
        if (!$this->derivativeForms->contains($derivativeForm)) {
            $this->derivativeForms[] = $derivativeForm;
            $derivativeForm->setBaseWord($this);
        }

        return $this;
    }

    public function removeDerivativeForm(DerivativeForm $derivativeForm): self
    {
        if ($this->derivativeForms->contains($derivativeForm)) {
            $this->derivativeForms->removeElement($derivativeForm);
            // set the owning side to null (unless already changed)
            if ($derivativeForm->getBaseWord() === $this) {
                $derivativeForm->setBaseWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WordTranslation[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(WordTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setWord($this);
        }

        return $this;
    }

    public function removeTranslation(WordTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            // set the owning side to null (unless already changed)
            if ($translation->getWord() === $this) {
                $translation->setWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WordRevision[]
     */
    public function getRevisions(): Collection
    {
        return $this->revisions;
    }

    public function addRevision(WordRevision $revision): self
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions[] = $revision;
            $revision->setObject($this);
        }

        return $this;
    }

    public function removeRevision(WordRevision $revision): self
    {
        if ($this->revisions->contains($revision)) {
            $this->revisions->removeElement($revision);
            // set the owning side to null (unless already changed)
            if ($revision->getObject() === $this) {
                $revision->setObject(null);
            }
        }

        return $this;
    }
}
