<?php

namespace JJ\WeddingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rsvp
 */
class Rsvp
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $referer;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $port;

    /**
     * @var \DateTime
     */
    private $formSubmitted;

    /**
     * @var \JJ\WeddingBundle\Entity\Party
     */
    private $party;

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
     * Set comment
     *
     * @param string $comment
     * @return Rsvp
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return Rsvp
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    
        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     * @return Rsvp
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    
        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string 
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Rsvp
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set port
     *
     * @param string $port
     * @return Rsvp
     */
    public function setPort($port)
    {
        $this->port = $port;
    
        return $this;
    }

    /**
     * Get port
     *
     * @return string 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set formSubmitted
     *
     * @param \DateTime $formSubmitted
     * @return Rsvp
     */
    public function setFormSubmitted($formSubmitted)
    {
        $this->formSubmitted = $formSubmitted;
    
        return $this;
    }

    public function prePersistFormSubmitted()
    {
        $this->formSubmitted = new \DateTime();
    }

    /**
     * Get formSubmitted
     *
     * @return \DateTime 
     */
    public function getFormSubmitted()
    {
        return $this->formSubmitted;
    }

    /**
     * Set party
     *
     * @param \JJ\WeddingBundle\Entity\Party $party
     * @return Rsvp
     */
    public function setParty(\JJ\WeddingBundle\Entity\Party $party = null)
    {
        $this->party = $party;
    
        return $this;
    }

    /**
     * Get party
     *
     * @return \JJ\WeddingBundle\Entity\Party 
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * Add registrants
     *
     * @param \JJ\WeddingBundle\Entity\Registrant $registrants
     * @return Rsvp
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

    protected $rsvpRegistrant = array(
        'rsvpType',
    );

    public function setRsvpRegistrant($key, $value)
    {
        $this->rsvpRegistrant[$key] = $value;
    }
}
