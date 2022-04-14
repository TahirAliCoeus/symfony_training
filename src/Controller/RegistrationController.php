<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }

    /**
     * @Route ("register")
     */
    public function create(UserPasswordHasherInterface $passwordHasher,ManagerRegistry $registry)
    {
        $user = new User();
        $user->setName("Dummy 2");
        $user->setEmail("tahir@test.com");
        $user->setAddress("lorem ipsum");
        $user->setPassword($passwordHasher->hashPassword($user,"password123"));

        $entityManager = $registry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response("Done");

    }
}
