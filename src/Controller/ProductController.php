<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\MessageGenerator;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route ("product/store/category/{id}",name="create_product")
     */
    public function store(ManagerRegistry $doctrine, Category $category): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName("Lenovo Thinkpad");
        $product->setDescription("Lorem ipsum");
        $product->setPrice(400);
        $product->setCategory($category);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response("Product saved and id is {$product->getId()}");
    }

    /**
     *@Route ("product/show/{id}",name="product_show")
     */
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneByIdJoinedToCategory($id);
        $response = new Response();
        return  $product ? $response->setContent("Name of product is {$product->getName()} and category is {$product->getCategory()->getName()}") : $response->setContent("No product found");
    }

    /**
     * @Route("/product/{name}")
     * @Entity("product", options={"mapping": {"name": "name"}})
     */
    public function list(Product $product)
    {
        $response = new Response();
        return $response->setContent("Name of product is {$product->getName()}");
    }

    /**
     * @Route ("product/update/{id}",name="product_update")
     */
    public function update(Product $product,ManagerRegistry $managerRegistry)
    {
        $product->setName("Phone");
        $entityManager = $managerRegistry->getManager();
        $entityManager->flush($product);
        return new Response("Product Updated");
    }
    /**
     * @Route ("product/filter/{minPrice}/{maxPrice}",name="product_filter")
     */
    public function filter(ManagerRegistry $managerRegistry, $minPrice, $maxPrice)
    {
        $entityManager = $managerRegistry->getManager();
        $products = $entityManager->getRepository(Product::class)->findAllBetweenPrice($minPrice,$maxPrice);
        dd($products);
    }

    /**
     * @Route ("product/filter/{name}",name="product_filter")
     */
    public function filterByName(ManagerRegistry $managerRegistry, $name)
    {
        $entityManager = $managerRegistry->getManager();
        $products = $entityManager->getRepository(Product::class)->findAllNameLike($name);
        dd($products);
    }


    /**
     * @Route("product/display/message")
     */
    public function displayMessage(MessageGenerator $messageGenerator): Response
    {
        $message = $messageGenerator->getHappyMessage();
        return  new Response($message);
    }



}
