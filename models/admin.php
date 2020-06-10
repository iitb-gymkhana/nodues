<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class Admin
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
    protected $rollNo;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="admins")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $section;

    public function __construct()
    {}

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of rollNo
     */
    public function getRollNo()
    {
        return $this->rollNo;
    }

    /**
     * Set the value of rollNo
     *
     * @return  self
     */
    public function setRollNo($rollNo)
    {
        $this->rollNo = $rollNo;

        return $this;
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
}
