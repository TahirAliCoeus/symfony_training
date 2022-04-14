<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route ("comment/add/{id}",name="comment_add")
     */
    public function store(ManagerRegistry $managerRegistry,$id)
    {
        $entityManager = $managerRegistry->getManager();
        $comment = new Comment();
        $user = $entityManager->getRepository(User::class)->find($id);

        $comment->setContent("This is another dummy comment");
        $comment->setUser($user);
        $comment->setAuthor($user);

        $entityManager->persist($comment);
        $entityManager->flush();
        dd($comment);
        return new Response("Comment added");

    }
}
