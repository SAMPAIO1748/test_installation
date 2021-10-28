<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        // find permet de trouver l'article dans la base de données qui a l'id correspondant
        $article = $articleRepository->find($id);
        return $this->render('article/article.html.twig', ['article' => $article]);
    }





    /**
     * @Route("bdd/update/article/{id}", name="article_update")
     */
    public function articleUpdate($id, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
    {
        $article = $articleRepository->find($id);
        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // persist préenregistre les données
            $entityManagerInterface->persist($article);
            // flush enregistre dans la base de données.
            $entityManagerInterface->flush();

            return $this->redirectToRoute("article_list");
        };

        return $this->render('article/update_article.html.twig', ['articleForm' => $articleForm->createView()]);
    }
}
