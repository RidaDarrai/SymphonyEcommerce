<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductsByCategoryController extends AbstractController
{
    #[Route('/products-by-category', name: 'app_products_by_category')]
    public function index(): Response
    {
        return $this->render('products_by_category/index.html.twig');
    }
}
