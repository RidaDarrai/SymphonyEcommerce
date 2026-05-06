<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductsByCategoryController extends AbstractController
{
    #[Route('/products-by-category/{id}', name: 'app_products_by_category')]
    public function index(int $id = 1): Response
    {
        $category = ['id' => $id, 'name' => 'Electronics', 'badge' => 'primary', 'productCount' => 12, 'description' => 'Discover the latest in technology and electronics.'];

        $products = [
            ['id' => 1, 'name' => 'Wireless Headphones', 'price' => 79.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 2, 'name' => 'Bluetooth Speaker', 'price' => 59.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 3, 'name' => 'Smartphone Stand', 'price' => 19.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 4, 'name' => 'USB-C Cable 2m', 'price' => 12.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 5, 'name' => 'Wireless Mouse', 'price' => 29.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 6, 'name' => 'Mechanical Keyboard', 'price' => 89.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 7, 'name' => 'Webcam HD 1080p', 'price' => 49.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 8, 'name' => 'Power Bank 20000mAh', 'price' => 39.99, 'badge' => 'primary', 'image' => 'mouse.png'],
            ['id' => 9, 'name' => 'Smart Watch Pro', 'price' => 199.99, 'badge' => 'primary', 'image' => 'mouse.png'],
        ];

        return $this->render('products_by_category/index.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
