<?php

namespace JJ\WeddingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Party
 */
class Party
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $brideOrGroom;

    /**
     * @var \JJ\WeddingBundle\Entity\Rsvp
     */
    private $rsvp;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $registrants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registrants = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Party
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set brideOrGroom
     *
     * @param string $brideOrGroom
     * @return Party
     */
    public function setBrideOrGroom($brideOrGroom)
    {
        $this->brideOrGroom = $brideOrGroom;
    
        return $this;
    }

    /**
     * Get brideOrGroom
     *
     * @return string 
     */
    public function getBrideOrGroom()
    {
        return $this->brideOrGroom;
    }

    /**
     * Set rsvp
     *
     * @param \JJ\WeddingBundle\Entity\Rsvp $rsvp
     * @return Party
     */
    public function setRsvp(\JJ\WeddingBundle\Entity\Rsvp $rsvp = null)
    {
        $this->rsvp = $rsvp;
    
        return $this;
    }

    /**
     * Get rsvp
     *
     * @return \JJ\WeddingBundle\Entity\Rsvp 
     */
    public function getRsvp()
    {
        return $this->rsvp;
    }

    /**
     * Add registrants
     *
     * @param \JJ\WeddingBundle\Entity\Registrant $registrants
     * @return Party
     */
    public function addRegistrant(\JJ\WeddingBundle\Entity\Registrant $registrants)
    {
        $this->registrants[] = $registrants;
    
        return $this;
    }

    /**
     * Remove registrants
     *
     * @param \JJ\WeddingBundle\Entity\Registrant $registrants
     */
    public function removeRegistrant(\JJ\WeddingBundle\Entity\Registrant $registrants)
    {
        $this->registrants->removeElement($registrants);
    }

    /**
     * Get registrants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegistrants()
    {
        return $this->registrants;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
