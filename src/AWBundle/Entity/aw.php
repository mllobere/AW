<?php

// src/AppBundle/Entity/aw.php
namespace AWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="aw")
 */
class aw
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="AWBundle\Entity\awuser" , inversedBy="aw_id")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $aw_visibility;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $aw_status;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $aw_date;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $aw_title;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $aw_ad;


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
     * Set aw_visibility
     *
     * @param boolean $awVisibility
     * @return aw
     */
    public function setAwVisibility($awVisibility)
    {
        $this->aw_visibility = $awVisibility;

        return $this;
    }

    /**
     * Get aw_visibility
     *
     * @return boolean
     */
    public function getAwVisibility()
    {
        return $this->aw_visibility;
    }

    /**
     * Set aw_status
     *
     * @param boolean $awStatus
     * @return aw
     */
    public function setAwStatus($awStatus)
    {
        $this->aw_status = $awStatus;

        return $this;
    }

    /**
     * Get aw_status
     *
     * @return boolean
     */
    public function getAwStatus()
    {
        return $this->aw_status;
    }

    /**
     * Set aw_date
     *
     * @param \DateTime $awDate
     * @return aw
     */
    public function setAwDate($awDate)
    {
        $this->aw_date = $awDate;

        return $this;
    }

    /**
     * Get aw_date
     *
     * @return \DateTime
     */
    public function getAwDate()
    {
        return $this->aw_date;
    }

    /**
     * Set aw_title
     *
     * @param string $awTitle
     * @return aw
     */
    public function setAwTitle($awTitle)
    {
        $this->aw_title = $awTitle;

        return $this;
    }

    /**
     * Get aw_title
     *
     * @return string
     */
    public function getAwTitle()
    {
        return $this->aw_title;
    }

    /**
     * Set aw_ad
     *
     * @param string $awAd
     * @return aw
     */
    public function setAwAd($awAd)
    {
        $this->aw_ad = $awAd;

        return $this;
    }

    /**
     * Get aw_ad
     *
     * @return string
     */
    public function getAwAd()
    {
        return $this->aw_ad;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return aw
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
