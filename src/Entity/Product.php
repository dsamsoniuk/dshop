<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price_net = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tax $tax = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPriceNet(): ?float
    {
        return $this->price_net;
    }

    public function setPriceNet(float $price_net): self
    {
        $this->price_net = $price_net;

        return $this;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getPriceGross(): ?float
    {
        return $this->price_net * ( 1+ ($this->tax/100) );
    }
}
