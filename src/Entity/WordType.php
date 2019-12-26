<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordTypeRepository")
 */
class WordType {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $name;

	/**
	 * @ORM\Column(type="smallint")
	 */
	private $idiNumber;

	/**
	 * @ORM\Column(type="string", length=60)
	 */
	private $speechPart;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $comment;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $rules;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $rulesTest;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $exampleWord;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Word", mappedBy="type")
     */
    private $words;

    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

	public function getId(): ?int {
                        		return $this->id;
                        	}

	public function getName(): ?string {
                        		return $this->name;
                        	}
	public function setName(string $name): self {
                        		$this->name = $name;
                        		return $this;
                        	}

	public function getIdiNumber(): ?int {
                        		return $this->idiNumber;
                        	}
	public function setIdiNumber(int $idiNumber): self {
                        		$this->idiNumber = $idiNumber;
                        		return $this;
                        	}

	public function getSpeechPart(): ?string {
                        		return $this->speechPart;
                        	}
	public function setSpeechPart(string $speechPart): self {
                        		$this->speechPart = $speechPart;
                        		return $this;
                        	}

	public function getComment(): ?string {
                        		return $this->comment;
                        	}
	public function setComment(?string $comment): self {
                        		$this->comment = $comment;
                        		return $this;
                        	}

	public function getRules(): ?string {
                        		return $this->rules;
                        	}
	public function setRules(?string $rules): self {
                        		$this->rules = $rules;
                        		return $this;
                        	}

	public function getRulesTest(): ?string {
                        		return $this->rulesTest;
                        	}
	public function setRulesTest(?string $rulesTest): self {
                        		$this->rulesTest = $rulesTest;
                        		return $this;
                        	}

	public function getExampleWord(): ?string {
                        		return $this->exampleWord;
                        	}
	public function setExampleWord(string $exampleWord): self {
                        		$this->exampleWord = $exampleWord;
                        		return $this;
                        	}

    /**
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWord(Word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
            $word->setType($this);
        }

        return $this;
    }

    public function removeWord(Word $word): self
    {
        if ($this->words->contains($word)) {
            $this->words->removeElement($word);
            // set the owning side to null (unless already changed)
            if ($word->getType() === $this) {
                $word->setType(null);
            }
        }

        return $this;
    }
}
