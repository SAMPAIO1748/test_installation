<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/bdd/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/bdd/articles", name="article_list")
     */                                 //Autowire
    public function articleList(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
        return $this->render('article/articles.html.twig', ['articles' => $articles]);
    }

    /**                     //Wildcard
     * @Route("/bdd/article/{id}", name="article_show")
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);
        return $this->render('article/article.html.twig', ['article' => $article]);
    }
}
