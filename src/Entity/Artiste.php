<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtisteRepository::class)
 */
class Artiste
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Spotify;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Deezer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annee;

    /**
     * @ORM\Column(type="json")
     */
    private $origine = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSpectacleSoiree;

    /**
     * @ORM\Column(type="array")
     */
    private $lang_code = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReceivingQuest;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_ilomember;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label_sp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label_en;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ONU_code;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="artistes")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Notification::class, mappedBy="artistes")
     */
    private $notifications;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="artisteed")
     */
    private $edition;

    /**
     * @ORM\OneToMany(targetEntity=Live::class, mappedBy="artist")
     */
    private $lives;

    /**
     * @ORM\ManyToMany(targetEntity=Live::class, inversedBy="artistes")
     */
    private $dates;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->lives = new ArrayCollection();
        $this->dates = new ArrayCollection();
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

    public function getSpotify(): ?string
    {
        return $this->Spotify;
    }

    public function setSpotify(?string $Spotify): self
    {
        $this->Spotify = $Spotify;

        return $this;
    }

    public function getDeezer(): ?string
    {
        return $this->Deezer;
    }

    public function setDeezer(?string $Deezer): self
    {
        $this->Deezer = $Deezer;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getOrigine(): ?array
    {
        return $this->origine;
    }

    public function setOrigine(array $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getNomSpectacleSoiree(): ?string
    {
        return $this->nomSpectacleSoiree;
    }

    public function setNomSpectacleSoiree(?string $nomSpectacleSoiree): self
    {
        $this->nomSpectacleSoiree = $nomSpectacleSoiree;

        return $this;
    }

    public function getLangCode(): ?array
    {
        return $this->lang_code;
    }

    public function setLangCode(array $lang_code): self
    {
        $this->lang_code = $lang_code;

        return $this;
    }

    public function getIsReceivingQuest(): ?bool
    {
        return $this->isReceivingQuest;
    }

    public function setIsReceivingQuest(bool $isReceivingQuest): self
    {
        $this->isReceivingQuest = $isReceivingQuest;

        return $this;
    }

    public function getIsIlomember(): ?bool
    {
        return $this->is_ilomember;
    }

    public function setIsIlomember(bool $is_ilomember): self
    {
        $this->is_ilomember = $is_ilomember;

        return $this;
    }

    public function getLabelSp(): ?string
    {
        return $this->label_sp;
    }

    public function setLabelSp(string $label_sp): self
    {
        $this->label_sp = $label_sp;

        return $this;
    }

    public function getLabelEn(): ?string
    {
        return $this->label_en;
    }

    public function setLabelEn(string $label_en): self
    {
        $this->label_en = $label_en;

        return $this;
    }

    public function getONUCode(): ?string
    {
        return $this->ONU_code;
    }

    public function setONUCode(string $ONU_code): self
    {
        $this->ONU_code = $ONU_code;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addArtiste($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeArtiste($this);
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->addArtiste($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            $notification->removeArtiste($this);
        }

        return $this;
    }

    public function getEdition(): ?Event
    {
        return $this->edition;
    }

    public function setEdition(?Event $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * @return Collection|Live[]
     */
    public function getLives(): Collection
    {
        return $this->lives;
    }

    public function addLife(Live $life): self
    {
        if (!$this->lives->contains($life)) {
            $this->lives[] = $life;
            $life->setArtist($this);
        }

        return $this;
    }

    public function removeLife(Live $life): self
    {
        if ($this->lives->removeElement($life)) {
            // set the owning side to null (unless already changed)
            if ($life->getArtist() === $this) {
                $life->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Live[]
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(Live $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates[] = $date;
        }

        return $this;
    }

    public function removeDate(Live $date): self
    {
        $this->dates->removeElement($date);

        return $this;
    }
}
