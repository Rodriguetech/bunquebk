<?php

namespace App\Entity;

use App\Repository\ScenarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScenarioRepository::class)
 */
class Scenario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=DetailScenario::class, mappedBy="scenario")
     */
    private $detailScenarios;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="scenario")
     */
    private $transactions;

    public function __construct()
    {
        $this->detailScenarios = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|DetailScenario[]
     */
    public function getDetailScenarios(): Collection
    {
        return $this->detailScenarios;
    }

    public function addDetailScenario(DetailScenario $detailScenario): self
    {
        if (!$this->detailScenarios->contains($detailScenario)) {
            $this->detailScenarios[] = $detailScenario;
            $detailScenario->setScenario($this);
        }

        return $this;
    }

    public function removeDetailScenario(DetailScenario $detailScenario): self
    {
        if ($this->detailScenarios->removeElement($detailScenario)) {
            // set the owning side to null (unless already changed)
            if ($detailScenario->getScenario() === $this) {
                $detailScenario->setScenario(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setScenario($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getScenario() === $this) {
                $transaction->setScenario(null);
            }
        }

        return $this;
    }
}
