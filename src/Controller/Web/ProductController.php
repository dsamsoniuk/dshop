<?php

namespace App\Controller\Web;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/web/product', name: 'app_web_product')]
    public function index(ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();

        return $this->render('web/product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }
}
