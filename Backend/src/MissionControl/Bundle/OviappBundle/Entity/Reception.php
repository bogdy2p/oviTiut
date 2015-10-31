<?php

namespace MissionControl\Bundle\OviappBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//ENTITATEA RECEPTIE E PRACTIC " USER "
//ENTITATEA PRODUS E PRACTIC " CAMPANIE "
use MissionControl\Bundle\OviappBundle\Entity\Furnizor;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * Reception
 *
 * @ORM\Table(name = "oviapp_reception")
 * @ORM\Entity
 */
class Reception
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
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Furnizor", inversedBy="receptions")
     * @ORM\JoinColumn(name="furnizor_id", referencedColumnName="id")
     * @Expose
     */
    protected $client;

    /**
     * @var string
     *
     * @ORM\Column(name="user_creator", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="date_created", type="string", length=255)
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="date_updated", type="string", length=255)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="products", type="string", length=255)
     */
    private $products;

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
     * Set user
     *
     * @param string $user
     *
     * @return Reception
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set dateCreated
     *
     * @param string $dateCreated
     *
     * @return Reception
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param string $dateUpdated
     *
     * @return Reception
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return string
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set products
     *
     * @param string $products
     *
     * @return Reception
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return string
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set client
     *
     * @param \MissionControl\Bundle\OviappBundle\Entity\Furnizor $client
     *
     * @return Reception
     */
    public function setClient(\MissionControl\Bundle\OviappBundle\Entity\Furnizor $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \MissionControl\Bundle\OviappBundle\Entity\Furnizor
     */
    public function getClient()
    {
        return $this->client;
    }
}
