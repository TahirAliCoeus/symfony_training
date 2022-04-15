<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Event\UserDeletedEvent;
use App\Event\UserSignedUpEvent;
use Doctrine\Persistence\ManagerRegistry;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
    public function store(ManagerRegistry $managerRegistry,EventDispatcherInterface $dispatcher)
    {
        $user = new User();
        $user->setName("John Doe");
        $user->setAddress("Lahore");
        $user->setEmail("test".uniqid()."@email.com");
        $user->setPassword("test".uniqid()."@email.com");

        $entityManager = $managerRegistry->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        $event = new UserSignedUpEvent($user);
        $dispatcher->dispatch($event,UserSignedUpEvent::NAME);

        $deletedEvent = new UserDeletedEvent($user);
        $dispatcher->dispatch($deletedEvent,UserDeletedEvent::NAME);

        return new Response("User added");

    }
    /**
     * @Route ("user/{id<\d+>}",name="user_show")
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

    /**
     * @Route ("user/session")
     */
    public function showUserFromSession(ManagerRegistry $registry)
    {
        $em = $registry->getManager();
        /**
         * @var User $user
         */
        $user = $this->getUser();
        ($user->getComments()->remove(0));

        $em->flush();
        dd("Done");

    }
    /**
     * @Route ("user/log/test")
     */
    public function logMessage(LoggerInterface $logger)
    {
        dd($logger->info("THIS IS TEST"));
    }
}
