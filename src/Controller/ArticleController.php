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

    /**
     * @Route("bdd/create/article/", name="article_create")
     */
    public function articleCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        // On instancie un nouvel article
        $article = new Article();
        // On crée un formulaire
        $articleForm = $this->createForm(ArticleType::class, $article);
        // Traitement des données du formulaire
        $articleForm->handleRequest($request);

        // si le formulaire est soumis et validé
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // on prérenrigistre les données de l'objet
            $entityManagerInterface->persist($article);
            // On envoie dans la base de données.
            $entityManagerInterface->flush();

            // On renvoie vers la route article_list
            return $this->redirectToRoute("article_list");
        }

        return $this->render('article/update_article.html.twig', ['articleForm' => $articleForm->createView()]);
    }

    /**
     * @Route("bdd/delete/article/{id}", name="article_delete")
     */
    public function articleDelete($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
    {
        $article = $articleRepository->find($id);
        // remove = supprime
        $entityManagerInterface->remove($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('article_list');
    }

    /**
     * @Route("/admin/test", name="admin_test")
     */
    public function adminTest()
    {
        dump('Test');
        die;
    }
}
