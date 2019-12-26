<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Revision {

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $field;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $oldValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $newValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPatrolled;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="revisions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    public function setOldValue(?string $oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->newValue;
    }

    public function setNewValue(?string $newValue): self
    {
        $this->newValue = $newValue;

        return $this;
    }

    public function getIsPatrolled(): ?bool
    {
        return $this->isPatrolled;
    }

    public function setIsPatrolled(bool $isPatrolled): self
    {
        $this->isPatrolled = $isPatrolled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
