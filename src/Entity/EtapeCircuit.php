<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtapeCircuitRepository")
 */
class EtapeCircuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="etapeCircuits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville_etape;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="etapeCircuits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $circuit_etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre_etape;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleEtape(): ?ville
    {
        return $this->ville_etape;
    }

    public function setVilleEtape(?ville $ville_etape): self
    {
        $this->ville_etape = $ville_etape;

        return $this;
    }

    public function getCircuitEtape(): ?circuit
    {
        return $this->circuit_etape;
    }

    public function setCircuitEtape(?circuit $circuit_etape): self
    {
        $this->circuit_etape = $circuit_etape;

        return $this;
    }

    public function getDureeEtape(): ?int
    {
        return $this->duree_etape;
    }

    public function setDureeEtape(int $duree_etape): self
    {
        $this->duree_etape = $duree_etape;

        return $this;
    }

    public function getOrdreEtape(): ?int
    {
        return $this->ordre_etape;
    }

    public function setOrdreEtape(int $ordre_etape): self
    {
        $this->ordre_etape = $ordre_etape;

        return $this;
    }
}
