<?php

namespace App\Controller\Web;

use App\Entity\Basket;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    #[Route('/web/basket', name: 'app_web_basket')]
    public function index(BasketRepository $basketRepository, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $basket = $basketRepository->findOneBy([
            'user' => $user,
        ]);

        if (!$basket) {
            $basket = new Basket();
            $basket->setUser($user);
            $basket->setActive(1);
            $em->persist($basket);
            $em->flush();
        }

        return $this->render('web/basket/index.html.twig', [
            'controller_name' => 'BasketController',
            'basket' => $basket
        ]);
    }
}
