<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncorrectFormRevisionRepository")
 */
class IncorrectFormRevision extends Revision {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IncorrectForm", inversedBy="revisions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $object;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?IncorrectForm
    {
        return $this->object;
    }

    public function setObject(?IncorrectForm $object): self
    {
        $this->object = $object;

        return $this;
    }
}
