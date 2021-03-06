<?php

namespace MissionControl\Bundle\OviappBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MissionControl\Bundle\OviappBundle\Entity\Reception;
// Relationship Mapping Metadata:
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
// For returning JSON content:
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * Produs
 *
 * @ORM\Table(name = "oviapp_product")
 * @ORM\Entity(repositoryClass="MissionControl\Bundle\OviappBundle\Entity\ProdusRepository")
 */
class Produs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nume", type="string", length=255)
     */
    private $nume;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantitate", type="integer")
     */
    private $cantitate;

    /**
     * @var integer
     *
     * @ORM\Column(name="pret_livrare", type="integer")
     */
    private $pretLivrare;

    /**
     * @var string
     *
     * @ORM\Column(name="unitate_masura", type="string", length=255)
     */
    private $unitateMasura;

    /**
     * @var integer
     *
     * @ORM\Column(name="adaos_comercial", type="integer")
     */
    private $adaosComercial;

    /**
     * @var integer
     *
     * @ORM\Column(name="tva", type="integer")
     */
    private $tva;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nume
     *
     * @param string $nume
     *
     * @return Produs
     */
    public function setNume($nume)
    {
        $this->nume = $nume;

        return $this;
    }

    /**
     * Get nume
     *
     * @return string
     */
    public function getNume()
    {
        return $this->nume;
    }

    /**
     * Set cantitate
     *
     * @param integer $cantitate
     *
     * @return Produs
     */
    public function setCantitate($cantitate)
    {
        $this->cantitate = $cantitate;

        return $this;
    }

    /**
     * Get cantitate
     *
     * @return integer
     */
    public function getCantitate()
    {
        return $this->cantitate;
    }

    /**
     * Set pretLivrare
     *
     * @param integer $pretLivrare
     *
     * @return Produs
     */
    public function setPretLivrare($pretLivrare)
    {
        $this->pretLivrare = $pretLivrare;

        return $this;
    }

    /**
     * Get pretLivrare
     *
     * @return integer
     */
    public function getPretLivrare()
    {
        return $this->pretLivrare;
    }

    /**
     * Set unitateMasura
     *
     * @param string $unitateMasura
     *
     * @return Produs
     */
    public function setUnitateMasura($unitateMasura)
    {
        $this->unitateMasura = $unitateMasura;

        return $this;
    }

    /**
     * Get unitateMasura
     *
     * @return string
     */
    public function getUnitateMasura()
    {
        return $this->unitateMasura;
    }

    /**
     * Set adaosComercial
     *
     * @param integer $adaosComercial
     *
     * @return Produs
     */
    public function setAdaosComercial($adaosComercial)
    {
        $this->adaosComercial = $adaosComercial;

        return $this;
    }

    /**
     * Get adaosComercial
     *
     * @return integer
     */
    public function getAdaosComercial()
    {
        return $this->adaosComercial;
    }

    /**
     * Set tva
     *
     * @param integer $tva
     *
     * @return Produs
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return integer
     */
    public function getTva()
    {
        return $this->tva;
    }
}
