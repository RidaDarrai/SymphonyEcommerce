<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowseCategoriesController extends AbstractController
{
    #[Route('/browse-categories', name: 'app_browse_categories')]
    public function index(): Response
    {
        $categories = [
            ['id' => 1, 'name' => 'Electronics', 'productCount' => 12, 'badge' => 'primary', 'description' => 'Headphones, speakers, gadgets and more'],
            ['id' => 2, 'name' => 'Fashion', 'productCount' => 18, 'badge' => 'warning', 'description' => 'Clothing, accessories and footwear'],
            ['id' => 3, 'name' => 'Home & Garden', 'productCount' => 15, 'badge' => 'success', 'description' => 'Furniture, decor and gardening tools'],
            ['id' => 4, 'name' => 'Sports & Fitness', 'productCount' => 10, 'badge' => 'info', 'description' => 'Workout gear, yoga mats and equipment'],
            ['id' => 5, 'name' => 'Books', 'productCount' => 8, 'badge' => 'danger', 'description' => 'Fiction, non-fiction and educational'],
            ['id' => 6, 'name' => 'Beauty & Health', 'productCount' => 14, 'badge' => 'secondary', 'description' => 'Skincare, cosmetics and wellness'],
            ['id' => 7, 'name' => 'Toys & Games', 'productCount' => 20, 'badge' => 'primary', 'description' => 'Fun for kids and family entertainment'],
            ['id' => 8, 'name' => 'Automotive', 'productCount' => 9, 'badge' => 'dark', 'description' => 'Car accessories and maintenance tools'],
            ['id' => 9, 'name' => 'Pet Supplies', 'productCount' => 11, 'badge' => 'warning', 'description' => 'Food, toys and accessories for pets'],
        ];

        return $this->render('browse_categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
