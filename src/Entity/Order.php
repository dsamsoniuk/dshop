<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Basket $basket = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Address $deliveryAddress = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Payment $payment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): self
    {
        $this->basket = $basket;

        return $this;
    }

    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(Address $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
}
