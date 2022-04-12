<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route ("/category/",name="category_")
 */
class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    /**
     * @Route ("store",name="store")
     */
    public function store(ManagerRegistry $managerRegistry)
    {
        $category = new Category();
        $category->setName("Headphones");

        $entityManager= $managerRegistry->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new Response("New category added");

    }
}
