<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function calcPrice(): Response
    {
        return new Response('ok');
    }

    public function pay(): Response
    {
        return new Response('ok');
    }
}
