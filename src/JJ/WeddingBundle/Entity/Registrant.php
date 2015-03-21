<?php

namespace JJ\WeddingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registrant
 */
class Registrant
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $middleName;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $suffix;

    /**
     * @var string
     */
    private $street1;

    /**
     * @var string
     */
    private $street2;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var boolean
     */
    private $headOfParty;

    /**
     * @var integer
     */
    private $orderOfParty;

    /**
     * @var string
     */
    private $adultChild;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $email;


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
     * Set lastName
     *
     * @param string $lastName
     * @return Registrant
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Registrant
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     * @return Registrant
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    
        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return Registrant
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    
        return $this;
    }

    /**
     * Get prefix
     *
     * @return string 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param string $suffix
     * @return Registrant
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    
        return $this;
    }

    /**
     * Get suffix
     *
     * @return string 
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set street1
     *
     * @param string $street1
     * @return Registrant
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;
    
        return $this;
    }

    /**
     * Get street1
     *
     * @return string 
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Set street2
     *
     * @param string $street2
     * @return Registrant
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
    
        return $this;
    }

    /**
     * Get street2
     *
     * @return string 
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Registrant
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Registrant
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Registrant
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    
        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Registrant
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set headOfParty
     *
     * @param boolean $headOfParty
     * @return Registrant
     */
    public function setHeadOfParty($headOfParty)
    {
        $this->headOfParty = $headOfParty;
    
        return $this;
    }

    /**
     * Get headOfParty
     *
     * @return boolean 
     */
    public function getHeadOfParty()
    {
        return $this->headOfParty;
    }

    /**
     * Set orderOfParty
     *
     * @param integer $orderOfParty
     * @return Registrant
     */
    public function setOrderOfParty($orderOfParty)
    {
        $this->orderOfParty = $orderOfParty;
    
        return $this;
    }

    /**
     * Get orderOfParty
     *
     * @return integer 
     */
    public function getOrderOfParty()
    {
        return $this->orderOfParty;
    }

    /**
     * Set adultChild
     *
     * @param string $adultChild
     * @return Registrant
     */
    public function setAdultChild($adultChild)
    {
        $this->adultChild = $adultChild;
    
        return $this;
    }

    /**
     * Get adultChild
     *
     * @return string 
     */
    public function getAdultChild()
    {
        return $this->adultChild;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Registrant
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Registrant
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var integer
     */
    private $orderInParty;

    /**
     * @var string
     */
    private $adultOrChild;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var \JJ\WeddingBundle\Entity\Party
     */
    private $party;


    /**
     * Set orderInParty
     *
     * @param integer $orderInParty
     * @return Registrant
     */
    public function setOrderInParty($orderInParty)
    {
        $this->orderInParty = $orderInParty;
    
        return $this;
    }

    /**
     * Get orderInParty
     *
     * @return integer 
     */
    public function getOrderInParty()
    {
        return $this->orderInParty;
    }

    /**
     * Set adultOrChild
     *
     * @param string $adultOrChild
     * @return Registrant
     */
    public function setAdultOrChild($adultOrChild)
    {
        $this->adultOrChild = $adultOrChild;
    
        return $this;
    }

    /**
     * Get adultOrChild
     *
     * @return string 
     */
    public function getAdultOrChild()
    {
        return $this->adultOrChild;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Registrant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set party
     *
     * @param \JJ\WeddingBundle\Entity\Party $party
     * @return Registrant
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
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @var string
     */
    private $rsvpType;

    /**
     * @var boolean
     */
    private $recieveUpdates;

    /**
     * @var \JJ\WeddingBundle\Entity\Rsvp
     */
    private $rsvp;


    /**
     * Set rsvpType
     *
     * @param string $rsvpType
     * @return Registrant
     */
    public function setRsvpType($rsvpType)
    {
        $this->rsvpType = $rsvpType;
    
        return $this;
    }

    /**
     * Get rsvpType
     *
     * @return string 
     */
    public function getRsvpType()
    {
        return $this->rsvpType;
    }

    /**
     * Set recieveUpdates
     *
     * @param boolean $recieveUpdates
     * @return Registrant
     */
    public function setRecieveUpdates($recieveUpdates)
    {
        $this->recieveUpdates = $recieveUpdates;
    
        return $this;
    }

    /**
     * Get recieveUpdates
     *
     * @return boolean 
     */
    public function getRecieveUpdates()
    {
        return $this->recieveUpdates;
    }

    /**
     * Set rsvp
     *
     * @param \JJ\WeddingBundle\Entity\Rsvp $rsvp
     * @return Registrant
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
     * @var string
     */
    private $country;


    /**
     * Set country
     *
     * @param string $country
     * @return Registrant
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
}