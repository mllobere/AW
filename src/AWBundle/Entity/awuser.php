<?php

// src/AppBundle/Entity/awuser.php
namespace AWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="awuser")
 */
class awuser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="AWBundle\Entity\aw" , mappedBy="Id")
     */
    protected $aw_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="AWBundle\Entity\User" , mappedBy="Id")
     */
    protected $user_id;

     /**
      * @ORM\Column(type="integer")
      */
    protected $awuser_invitedby;

    /**
     * @ORM\Column(type="integer")
     */
    protected $awuser_answer;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $awuser_answercomment;


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
     * Set aw_id
     *
     * @param integer $awId
     * @return awuser
     */
    public function setAwId($awId)
    {
        $this->aw_id = $awId;

        return $this;
    }

    /**
     * Get aw_id
     *
     * @return integer
     */
    public function getAwId()
    {
        return $this->aw_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return awuser
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set awuser_invitedby
     *
     * @param integer $awuserInvitedby
     * @return awuser
     */
    public function setAwuserInvitedby($awuserInvitedby)
    {
        $this->awuser_invitedby = $awuserInvitedby;

        return $this;
    }

    /**
     * Get awuser_invitedby
     *
     * @return integer
     */
    public function getAwuserInvitedby()
    {
        return $this->awuser_invitedby;
    }

    /**
     * Set awuser_answer
     *
     * @param integer $awuserAnswer
     * @return awuser
     */
    public function setAwuserAnswer($awuserAnswer)
    {
        $this->awuser_answer = $awuserAnswer;

        return $this;
    }

    /**
     * Get awuser_answer
     *
     * @return integer
     */
    public function getAwuserAnswer()
    {
        return $this->awuser_answer;
    }

    /**
     * Set awuser_answercomment
     *
     * @param string $awuserAnswercomment
     * @return awuser
     */
    public function setAwuserAnswercomment($awuserAnswercomment)
    {
        $this->awuser_answercomment = $awuserAnswercomment;

        return $this;
    }

    /**
     * Get awuser_answercomment
     *
     * @return string
     */
    public function getAwuserAnswercomment()
    {
        return $this->awuser_answercomment;
    }
}
