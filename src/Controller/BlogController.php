<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route ("/blog",name="blog_")
 */
class BlogController extends AbstractController
{

    public function list(int $page) : Response
    {
        return  new Response($page);
    }

    /**
     * @Route ("/show/{slug}",methods={"GET"},name="show")
    */
    public function show(string $slug,Request $request) : Response
    {

        return  new Response($request->attributes->get("_route"));
    }
}