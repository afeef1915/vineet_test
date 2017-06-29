<?php

namespace Acme\Bundle\BitcoinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlertData
 */
class AlertData
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone_number;

    /**
     * @var string
     */
    private $buy_min;

    /**
     * @var string
     */
    private $buy_max;

    /**
     * @var string
     */
    private $sell_min;

    /**
     * @var string
     */
    private $sell_max;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;


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
     * Set email
     *
     * @param string $email
     * @return AlertData
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
     * Set phone_number
     *
     * @param string $phoneNumber
     * @return AlertData
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phone_number
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set buy_min
     *
     * @param string $buyMin
     * @return AlertData
     */
    public function setBuyMin($buyMin)
    {
        $this->buy_min = $buyMin;

        return $this;
    }

    /**
     * Get buy_min
     *
     * @return string 
     */
    public function getBuyMin()
    {
        return $this->buy_min;
    }

    /**
     * Set buy_max
     *
     * @param string $buyMax
     * @return AlertData
     */
    public function setBuyMax($buyMax)
    {
        $this->buy_max = $buyMax;

        return $this;
    }

    /**
     * Get buy_max
     *
     * @return string 
     */
    public function getBuyMax()
    {
        return $this->buy_max;
    }

    /**
     * Set sell_min
     *
     * @param string $sellMin
     * @return AlertData
     */
    public function setSellMin($sellMin)
    {
        $this->sell_min = $sellMin;

        return $this;
    }

    /**
     * Get sell_min
     *
     * @return string 
     */
    public function getSellMin()
    {
        return $this->sell_min;
    }

    /**
     * Set sell_max
     *
     * @param string $sellMax
     * @return AlertData
     */
    public function setSellMax($sellMax)
    {
        $this->sell_max = $sellMax;

        return $this;
    }

    /**
     * Get sell_max
     *
     * @return string 
     */
    public function getSellMax()
    {
        return $this->sell_max;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AlertData
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return AlertData
     */
    public function setStartDate($startDate)
    {
        $this->start_date = new \DateTime("now");

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return AlertData
     */
    public function setEndDate($endDate)
    {
        $this->end_date = new \DateTime("now");

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
}
