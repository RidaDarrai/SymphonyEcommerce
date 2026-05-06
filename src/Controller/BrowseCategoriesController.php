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
        return $this->render('browse_categories/index.html.twig');
    }
}
