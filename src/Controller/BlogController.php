<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route ("/blog",name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route ("/show/{page}",requirements={"page"="\d+"})
     */
    public function list(int $page) : Response
    {
        return  new Response($page);
    }

    /**

    */
    public function show(string $slug) : Response
    {

        return  new Response($slug);
    }

    /**
     * @Route("/count",name="count")
     */
    public function getCount()
    {
        $blog = null;
        if(!$blog)
        {
            throw $this->createNotFoundException("Blog does not exist");
        }
    }

    /**
     * @Route("/search",name="search")
     */

    public function search(Request $request) : Response
    {
        return new Response("you searched for {$request->query->get('search')}");
    }
    /**
     * @Route("/store/{title}",name="store_title")
     */
    public function storeTitleInSession(string $title, SessionInterface $session) : RedirectResponse
    {
        $session->set("title",$title);
        return $this->redirectToRoute("blog_show_title",[]);
    }
    /**
     * @Route("/title",name="show_title")
     */
    public function fetchTitleFromSession(SessionInterface $session)
    {
        return $this->json(["title" => $session->get("title")],200);
    }
}