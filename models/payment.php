<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="payments")
 */
class Payment
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

    /**
     * @ORM\Column(type="string")
     */
    protected $transactionId;

    /**
     * @ORM\Column(type="string")
     */
    protected $comments;

    /**
     * @ORM\Column(type="string")
     */
    protected $updatedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedOn;

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

    /**
     * Get the value of transactionId
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set the value of transactionId
     *
     * @return  self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get the value of comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get the value of updatedBy
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set the value of updatedBy
     *
     * @return  self
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get the value of updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set the value of updatedOn
     *
     * @return  self
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}
