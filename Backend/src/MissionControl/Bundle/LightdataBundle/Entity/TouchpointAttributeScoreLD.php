<?php

namespace MissionControl\Bundle\LightdataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * TouchpointAttributeScoreLD
 *
 * @ORM\Table(name = "lightdata_touchpoint_attributescore")
 * @ORM\Entity
 */
class TouchpointAttributeScoreLD {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Exclude
     */
    private $id;

    /**
     * @var TouchpointLD
     *
     * @ORM\ManyToOne(targetEntity="MissionControl\Bundle\LightdataBundle\Entity\TouchpointLD", inversedBy="touchpointattributescores")
     * @ORM\JoinColumn(name="touchpoint_id", referencedColumnName="id")
     * @Exclude
     */
    protected $touchpoint;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;


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
     * Set value
     *
     * @param float $value
     * @return TouchpointAttributeScoreLD
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set touchpoint
     *
     * @param \MissionControl\Bundle\LightdataBundle\Entity\TouchpointLD $touchpoint
     * @return TouchpointAttributeScoreLD
     */
    public function setTouchpoint(\MissionControl\Bundle\LightdataBundle\Entity\TouchpointLD $touchpoint = null)
    {
        $this->touchpoint = $touchpoint;

        return $this;
    }

    /**
     * Get touchpoint
     *
     * @return \MissionControl\Bundle\LightdataBundle\Entity\TouchpointLD 
     */
    public function getTouchpoint()
    {
        return $this->touchpoint;
    }
}
