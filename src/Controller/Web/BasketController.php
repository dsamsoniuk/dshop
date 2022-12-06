<?php

namespace App\Controller\Web;

use App\Entity\Basket;
use App\Entity\BasketDetails;
use App\Entity\Product;
use App\Repository\BasketRepository;
use App\Service\BasketService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('web/')]
class BasketController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private BasketRepository $basketRepository,
        private BasketService $basketService,
        )
    {
    }
    #[Route('basket/', name: 'app_web_basket')]
    public function index(): Response
    {

        $basket = $this->basketService->getBasket();

        return $this->render('web/basket/index.html.twig', [
            'controller_name' => 'BasketController',
            'basket' => $basket
        ]);
    }

    #[Route('basket/product/{product}/{qty}/add', name: 'app_web_basket_add_product', methods: ['GET'])]
    public function addProductToBasket(Product $product, int $qty = 1)
    {
        $basket = $this->basketService->getBasket();

        $basket->addProduct($product, $qty);
        $this->em->persist($basket);
        $this->em->flush();

        return $this->redirectToRoute('app_web_basket');
    }
}
