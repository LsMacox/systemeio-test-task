<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function calcPrice(string $slug): Response
    {
        return new Response($slug);
    }

    public function pay(string $slug): Response
    {
        return new Response($slug);
    }
}