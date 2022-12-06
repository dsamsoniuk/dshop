<?php

namespace App\Dto;

class OrderDto
{
    private ?int $basket = null;
    private ?int $addressDelivery = null;
    private ?int $supplier = null;

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
}
