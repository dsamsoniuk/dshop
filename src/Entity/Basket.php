<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: BasketDetails::class, cascade:['persist'])]
    private Collection $basketDetails;

    public function __construct()
    {
        $this->basketDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, BasketDetails>
     */
    public function getBasketDetails(): Collection
    {
        return $this->basketDetails;
    }

    public function addBasketDetails(BasketDetails $basketDetail): self
    {
        if (!$this->basketDetails->contains($basketDetail)) {

            $this->basketDetails->add($basketDetail);
            $basketDetail->setBasket($this);
        }

        return $this;
    }

    public function removeBasketDetail(BasketDetails $basketDetail): self
    {
        if ($this->basketDetails->removeElement($basketDetail)) {
            // set the owning side to null (unless already changed)
            if ($basketDetail->getBasket() === $this) {
                $basketDetail->setBasket(null);
            }
        }

        return $this;
    }

    public function addProduct(Product $product, int $qty = 0){
        /** @var BasketDetails $bd */
        foreach ($this->basketDetails as $bd) {
            if ($bd->getProduct() == $product) {
                $bd->setQuantity($bd->getQuantity() + $qty);
                return $this;
            }
        }

        $bd = new BasketDetails();
        $bd->setProduct($product);
        $bd->setQuantity($qty);
        $this->addBasketDetails($bd);
    }
}
