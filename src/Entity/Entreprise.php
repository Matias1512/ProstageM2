<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank(message="Le nom de l'entreprise doit être renseigner.")
     * @Assert\Length(min=4, minMessage="Doit faire plus de {{limite}} caractères.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     * @Assert\Url(message="Cette valeur n'est pas une URL valide.")
     */
    private $siteWeb;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     * @Assert\NotBlank
     */
    private $stageEntreprise;

    public function __construct()
    {
        $this->stageEntreprise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStageEntreprise(): Collection
    {
        return $this->stageEntreprise;
    }

    public function addStageEntreprise(Stage $stageEntreprise): self
    {
        if (!$this->stageEntreprise->contains($stageEntreprise)) {
            $this->stageEntreprise[] = $stageEntreprise;
            $stageEntreprise->setEntreprise($this);
        }

        return $this;
    }

    public function removeStageEntreprise(Stage $stageEntreprise): self
    {
        if ($this->stageEntreprise->removeElement($stageEntreprise)) {
            // set the owning side to null (unless already changed)
            if ($stageEntreprise->getEntreprise() === $this) {
                $stageEntreprise->setEntreprise(null);
            }
        }

        return $this;
    }
}
