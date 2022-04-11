<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\Type\BlogType;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @Route ("/show/{slug}")
    */
    public function show(string $slug) : Response
    {
        $message = "Article title is {$slug} and default language is {$this->getParameter("app.default_language")}";
        return  new Response($message);
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

    /**
    *@Route("/success",name="success")
     */
    public function showSuccessForm() : Response
    {
        return new Response("Blog added successfully");
    }

    /**
    * @Route ("/add")
     */
    public function add(Request $request,SluggerInterface $slugger) : Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class,$blog);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $blog = $form->getData();
            $blogThumbnail = $form->get("thumbnail")->getData();
            if($blogThumbnail)
            {
                $originalName = pathinfo($blogThumbnail->getClientOriginalName(),PATHINFO_FILENAME);
                $blogThumbnailName = $slugger->slug($originalName)."_".uniqid().".".$blogThumbnail->guessExtension();

                try {
                    $blogThumbnail->move($this->getParameter("app.blog_thumbnail_dir"),$blogThumbnailName);
                }catch (\Exception $exception)
                {
                    if($this->getParameter("kernel.environment") == "dev")
                        dd($exception->getMessage());
                    //TODO : return error for prod
                }
            }
            $blog->setThumbnailName($blogThumbnailName);
            return $this->redirectToRoute("blog_success");
        }
        return $this->renderForm("blog/add.html.twig",[
            "form" => $form
        ]);
    }

    /**
     * @Route("/edit")
     */
    public function loadEditBlogForm(Request $request) : Response
    {
        $blog = new Blog();
        $blog->setTitle("Travelling");
        $blog->setContent("This is just dummy content");

        $form = $this->createForm(BlogType::class,$blog,["action" => $this->generateUrl("blog_update")]);

        return $this->renderForm("blog/add.html.twig",[
            "form" => $form
        ]);
    }

    /**
     * @Route("/update",name="update")
     */
    public function update(Request $request)
    {
        $updatedBlog = $request->get("blog");
        return new Response("Updated blog title is {$updatedBlog['title']}");
    }




}