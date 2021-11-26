<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Lieu::class, inversedBy="events")
     */
    private $lieux;

    /**
     * @ORM\ManyToMany(targetEntity=Artiste::class, inversedBy="events")
     */
    private $artistes;

    /**
     * @ORM\Column(type="date")
     */
    private $debut;

    /**
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\OneToMany(targetEntity=Artiste::class, mappedBy="edition")
     */
    private $artisteed;

    public function __construct()
    {
        $this->lieux = new ArrayCollection();
        $this->artistes = new ArrayCollection();
        $this->artisteed = new ArrayCollection();
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

    /**
     * @return Collection|Lieu[]
     */
    public function getLieux(): Collection
    {
        return $this->lieux;
    }

    public function addLieux(Lieu $lieux): self
    {
        if (!$this->lieux->contains($lieux)) {
            $this->lieux[] = $lieux;
        }

        return $this;
    }

    public function removeLieux(Lieu $lieux): self
    {
        $this->lieux->removeElement($lieux);

        return $this;
    }

    /**
     * @return Collection|Artiste[]
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes[] = $artiste;
        }

        return $this;
    }

    public function removeArtiste(Artiste $artiste): self
    {
        $this->artistes->removeElement($artiste);

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection|Artiste[]
     */
    public function getArtisteed(): Collection
    {
        return $this->artisteed;
    }

    public function addArtisteed(Artiste $artisteed): self
    {
        if (!$this->artisteed->contains($artisteed)) {
            $this->artisteed[] = $artisteed;
            $artisteed->setEdition($this);
        }

        return $this;
    }

    public function removeArtisteed(Artiste $artisteed): self
    {
        if ($this->artisteed->removeElement($artisteed)) {
            // set the owning side to null (unless already changed)
            if ($artisteed->getEdition() === $this) {
                $artisteed->setEdition(null);
            }
        }

        return $this;
    }
}
