<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/bdd/categories/", name="categories_list")
     */
    public function categoriesList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/categories.html.twig', ['categories' => $categories]);
    }

    /**                       // Wildcard
     * @Route("/bdd/category/{id}", name="category_show")
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $categorie = $categoryRepository->find($id);
        return $this->render('category/category.html.twig', ['categorie' => $categorie]);
    }

    /**
     * @Route("/bdd/update/category/{id}", name="category_update")
     */
    public function categoryUpdate(
        $id,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        CategoryRepository $categoryRepository
    ) {
        $categorie = $categoryRepository->find($id);

        $categorieForm = $this->createForm(CategoryType::class, $categorie);

        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted() && $categorieForm->isValid()) {
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('categories_list');
        }

        return $this->render('category/update_category.html.twig', ['categoryForm' => $categorieForm->createView()]);
    }

    /**
     * @Route("/bdd/create/category", name="category_create")
     */
    public function categoryCreate(
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {
        $categorie = new Category();

        $categorieForm = $this->createForm(CategoryType::class, $categorie);

        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted() && $categorieForm->isValid()) {
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('categories_list');
        }

        return $this->render('category/update_category.html.twig', ['categoryForm' => $categorieForm->createView()]);
    }

    /**
     * @Route("bdd/delete/category/{id}", name="delete_category")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManagerInterface)
    {
        $categorie = $categoryRepository->find($id);
        $entityManagerInterface->remove($categorie);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('categories_list');
    }
}
