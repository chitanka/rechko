<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRevisionRepository")
 */
class WordRevision extends Revision {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Word", inversedBy="revisions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $object;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?Word
    {
        return $this->object;
    }

    public function setObject(?Word $object): self
    {
        $this->object = $object;

        return $this;
    }
}
