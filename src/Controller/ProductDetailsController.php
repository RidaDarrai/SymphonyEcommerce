<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductDetailsController extends AbstractController
{
    #[Route('/product-details/{id}', name: 'app_product_details')]
    public function index(int $id = 1): Response
    {
        $product = [
            'id' => $id,
            'name' => 'Wireless Headphones',
            'price' => 79.99,
            'badge' => 'primary',
            'image' => 'airbod.png',
            'sku' => 'WH-2024-001',
            'stock' => 'In Stock',
            'category' => 'Electronics',
            'description' => 'Experience premium sound quality with our wireless headphones. Featuring advanced noise cancellation technology, comfortable over-ear design, and up to 30 hours of battery life. Perfect for music lovers, travelers, and professionals. The foldable design makes them easy to carry, while the premium materials ensure durability and long-lasting comfort.'
        ];

        return $this->render('product_details/index.html.twig', [
            'product' => $product,
        ]);
    }
}
