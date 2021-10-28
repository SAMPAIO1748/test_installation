<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        // find permet de trouver l'article dans la base de données qui a l'id correspondant
        $article = $articleRepository->find($id);
        return $this->render('article/article.html.twig', ['article' => $article]);
    }

    /**
     * @Route("bdd/up/article", name="article_up")
     */
    public function articleUpdate(ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
    {

        $id = 5;
        // find permet de trouver l'article dans la base de données qui a l'id correspondant
        $article = $articleRepository->find($id);
        $article->setTitle("Vive la Bretagne");

        // persist préenregistre les données avant dans les mettre dans la base de données 
        $entityManagerInterface->persist($article);

        // On enregiste les données dans la base de données
        $entityManagerInterface->flush();

        return $this->redirectToRoute("article_list");
    }

    // Exercice : modifier le contenu de l'article qui a le titre Vive la guyane, le nouveau contenu sera "La Guyane,c'est fantastique".

    /**
     * @Route("bdd/update/article", name="article_update")
     */
    public function articleUp(ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
    {
        $id = 7;
        $article = $articleRepository->find($id);

        $article->setContent("La Guyane,c'est fantastique");
        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("article_list");
    }
}
