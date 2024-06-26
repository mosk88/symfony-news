<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'ACCUEIL',
        ]);
    }
     #[Route('/about', name:'app_about')]
     public function about(): Response
     {
         return $this->render('index/about.html.twig', [
            'controller_name' => 'About',
         ]);
     }
}
