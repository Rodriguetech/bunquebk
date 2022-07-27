<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
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
    private $bankName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Scenario::class, inversedBy="transactions")
     */
    private $scenario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listeScenario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listeScenarioDone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listeCode;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="transactionUser")
     */
    private $user;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getScenario(): ?Scenario
    {
        return $this->scenario;
    }

    public function setScenario(?Scenario $scenario): self
    {
        $this->scenario = $scenario;

        return $this;
    }

    public function getListeScenario(): ?string
    {
        return $this->listeScenario;
    }

    public function setListeScenario(string $listeScenario): self
    {
        $this->listeScenario = $listeScenario;

        return $this;
    }

    public function getListeScenarioDone(): ?string
    {
        return $this->listeScenarioDone;
    }

    public function setListeScenarioDone(string $listeScenarioDone): self
    {
        $this->listeScenarioDone = $listeScenarioDone;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getListeCode(): ?string
    {
        return $this->listeCode;
    }

    public function setListeCode(string $listeCode): self
    {
        $this->listeCode = $listeCode;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

}
