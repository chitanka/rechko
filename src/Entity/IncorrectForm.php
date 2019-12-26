<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncorrectFormRepository")
 */
class IncorrectForm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Word", inversedBy="incorrectForms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $correctWord;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $searchCount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IncorrectFormRevision", mappedBy="object", orphanRemoval=true)
     */
    private $revisions;

    public function __construct()
    {
        $this->revisions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCorrectWord(): ?Word
    {
        return $this->correctWord;
    }

    public function setCorrectWord(?Word $correctWord): self
    {
        $this->correctWord = $correctWord;

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
     * @return Collection|IncorrectFormRevision[]
     */
    public function getRevisions(): Collection
    {
        return $this->revisions;
    }

    public function addRevision(IncorrectFormRevision $revision): self
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions[] = $revision;
            $revision->setObject($this);
        }

        return $this;
    }

    public function removeRevision(IncorrectFormRevision $revision): self
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
