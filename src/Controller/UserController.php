<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
    * @Route ("user/add",name="user_add")
     */
    public function store(ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $user->setName("John Doe");
        $user->setAddress("Lahore");

        $entityManager = $managerRegistry->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response("User added");

    }
    /**
     * @Route ("user/{id}",name="user_show")
     */
    public function show(User $user,ManagerRegistry $registry)
    {
        $entityManger = $registry->getManager();
        $favComment = $registry->getRepository(Comment::class)->find(9);
        $comments = "";

        $user->getFavoriteComments()->add($favComment);
        ($favComment->getUserFavorites()->add($user));
        dd($entityManger->flush());


        return new Response("Name of user is {$user->getName()} and comments are: {$comments}");
    }
}
