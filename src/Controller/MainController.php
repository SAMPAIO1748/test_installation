<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    private $tableau_articles = [
        1 => [
            "titre" => "Vive la Bretagne",
            "contenu" => "La Bretagne c'est maginifique",
            "id" => 1
        ],
        2 => [
            "titre" => "Vive la Normandie",
            "contenu" => "La Normandie c'est très beau",
            "id" => 2
        ],
        3 => [
            "titre" => "Vive la Guyane",
            "contenu" => "La Guyane c'est fantastique",
            "id" => 3
        ],
    ];

    private $tableau_categorie = [
        1 => [
            "nom" => "Politique",
            "description" => "Tous savoir sur la politique",
            "id" => 1
        ],
        2 => [
            "nom" => "Economie",
            "description" => "Tous savoir sur l'économie",
            "id" => 2
        ],
        3 => [
            "nom" => "Technologie",
            "description" => "Tous savoir sur la technologie",
            "id" => 3
        ],
        4 => [
            "nom" => "Obi-wan Kenobi",
            "description" => "Tous savoir sur Obi-wan Kenobi",
            "id" => 4
        ]
    ];

    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    // Wildcard permet de mettre un paramètre dans l'URL
    /**
     * @Route("/home/{id}", name="home")
     */
    public function home($id)
    {

        // Exercice : Afficher le titre correspondant à l'id de la route.

        $tableau_articles = [
            1 => [
                "titre" => "Vive la Bretagne",
                "contenu" => "La Bretagne c'est maginifique",
                "id" => 1
            ],
            2 => [
                "titre" => "Vive la Normandie",
                "contenu" => "La Normandie c'est très beau",
                "id" => 2
            ],
            3 => [
                "titre" => "Vive la Guyane",
                "contenu" => "La Guyane c'est fantastique",
                "id" => 3
            ],
        ];

        return new Response('Le titre de l\'article est : ' . $tableau_articles[$id]['titre']);
    }

    // Exercice : Créez une route pour afficher la page des mentions légales, le texte qui devra s'afficher sera : Mentions légales du site

    /**
     * @Route("/legal/", name="legal")
     */
    public function legalMention()
    {
        // Je retourne une réponse HTTP valide en utilisant la classe Response
        // du composant HTTPFoundation 
        return new Response("Mentions légales du site");
    }

    /**
     * @Route("/about", name="apropos")
     */
    public function about()
    {
        // Render permet de retourner un fichier twig qui est une vue du site
        return $this->render('about.html.twig');
    }

    // Exercice : créez une route welcome qui va afficher le ficher welcome.html.twig où il y aura un titre h1 "Bienvenue"

    /**
     * @Route("/welcome/", name="welcome_home")
     */
    public function welcome()
    {
        return $this->render('welcome.html.twig');
    }

    // Execrice créer une route poker avec un paramètre age si l'age est inférieur à 18
    // on va vers une page qui affiche accés interdit et si 
    // l'âge est supérieur ou égale à 18 on va vers une page qui affiche accés autorisé. 

    /**
     * @Route("/poker/{age}", name="poker")
     */
    public function poker($age)
    {
        if ($age >= 18) {
            // Retourne vers une route qui existe dans le controller 
            // la fonction redirectToRoute demande le nom de la route et les paramètres
            // si nécessaire
            return $this->redirectToRoute('adulte', ['age' => $age]);
        } else {
            return $this->redirectToRoute('enfant', ['age' => $age]);
        }
    }

    /**
     * @Route("/adult/{age}", name="adulte")
     */
    public function adult($age)
    {
        return $this->render('adulte.html.twig', ['age' => $age]);
    }

    /**
     * @Route("/enfant/{age}", name="enfant")
     */
    public function enfant($age)
    {
        return $this->render('enfant.html.twig', ['age' => $age]);
    }

    /**
     * @Route("article/{id}", name="article")
     */
    public function articleShow($id)
    {
        // Rappel du tableau qui est un attribut de MainController
        $tableau =  $this->tableau_articles;

        return $this->render("article.html.twig", ['article' => $tableau[$id]]);
    }

    /**
     * @Route("articles/", name="aricles_list")
     */
    public function articleList()
    {
        // Rappel du tableau qui est un attribut de MainController
        $tableau = $this->tableau_articles;

        // Réponse par un vue avec un fichier twig auquel on ajoute une variable
        // qui sera disponible dans le fichier twig
        return $this->render("articles.html.twig", ['articles' => $tableau]);
    }

    /**
     * @Route("/categories", name="categorie_list")
     */
    public function categorieList()
    {
        $list = $this->tableau_categorie;

        return $this->render("categories.html.twig", ['categories' => $list]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie")
     */
    public function categorieShow($id)
    {
        $categorie = $this->tableau_categorie[$id];

        return $this->render("categorie.html.twig", ['categorie' => $categorie]);
    }

    /**
     * @Route("/index", name="index")
     */
    public function index1()
    {
        return $this->render('index.html.twig');
    }

    // Exercice créer un fichier bases.html.twig qui aura 
    /*

        <!DOCTYPE html>
        <html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		{% block stylesheets %}
		{% endblock %}
		<title>Document</title>
        </head>
        <body>

            {% block header %}{% endblock %}

            {% block main %}{% endblock %}

            {% block footer %}{% endblock %}

	    </body>
    </html>
	

     Appliquer cette base à article.html.twig et articles.html.twig
    */
}
