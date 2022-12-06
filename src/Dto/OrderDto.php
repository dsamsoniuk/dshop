<?php

namespace App\Dto;

class OrderDto
{
    private ?int $basket = null;
    private ?int $addressDelivery = null;
    private ?int $payment = null;

    /**
     * Get the value of basket
     */ 
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set the value of basket
     *
     * @return  self
     */ 
    public function setBasket($basket)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get the value of addressDelivery
     */ 
    public function getAddressDelivery()
    {
        return $this->addressDelivery;
    }

    /**
     * Set the value of addressDelivery
     *
     * @return  self
     */ 
    public function setAddressDelivery($addressDelivery)
    {
        $this->addressDelivery = $addressDelivery;

        return $this;
    }

    /**
     * Get the value of payment
     */ 
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set the value of payment
     *
     * @return  self
     */ 
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }
}
