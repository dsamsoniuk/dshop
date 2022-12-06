<?php

namespace App\Service;

use App\Entity\Basket;
use App\Entity\Product;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PropertyAccess\Exception\AccessException;

class BasketService
{

    public function __construct(
        private Security $security,
        private BasketRepository $basketRepository,
        private EntityManagerInterface $em
        ) {}
    public function getBasket(): ?Basket {

        $user = $this->security->getUser();
        $basket = $this->basketRepository->findOneBy([
            'user' => $user,
        ]);

        if (!$basket) {
            $basket = new Basket();
            $basket->setUser($user);
            $basket->setActive(1);
            $this->em->persist($basket);
            $this->em->flush();
        }
        return $basket;
    }
}
