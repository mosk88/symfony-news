<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path:'/api')]
class ApiController extends AbstractController
{
    #[Route('/articles', name: 'api_articles')]
    public function articles(ArticleRepository $articleRepository): JsonResponse
    {
        $articles = $articleRepository->findAll();

        return $this->json(
            $articles,
            context: ['groups' => ['articles:read'],
            // DateTimeNormalizer::FORMAT_KEY => 'd/m/Y']
        ]);

        // return $this->json($articleRepository->findAll());
    }
    #[Route('/articles/{id}', name: 'api_article_item')]
    public function article(ArticleRepository $articleRepository,int $id): JsonResponse
    {
        $article = $articleRepository->findById($id);

        return $this->json(
            $article,
            context: [
                'groups' => ['article:read'],
                
            ]
        );

     
    }
    #[Route('/categories', name: 'api_categories')]
    public function categories(CategoryRepository $categoryRepository): JsonResponse
    {
        return $this->json($categoryRepository->findAll(),
        context: ['groups'=> ['categories:read'],
    ]);
    }
}
