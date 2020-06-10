<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="sections")
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $section;

    /**
     * @ORM\Column(type="string")
     */
    protected $displayName;

    /**
     * @ORM\OneToMany(targetEntity="Due", mappedBy="section")
     */
    protected $dues;

    /**
     * @ORM\OneToMany(targetEntity="Admin", mappedBy="section")
     */
    protected $admins;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="section")
     */
    protected $payments;

    public function __construct()
    {
        $this->dues = new ArrayCollection();
        $this->admins = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the value of section
     *
     * @return  self
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get the value of displayName
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set the value of displayName
     *
     * @return  self
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get the value of dues
     */
    public function getDues()
    {
        return $this->dues;
    }

    /**
     * Get the value of admins
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * Get the value of payments
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
