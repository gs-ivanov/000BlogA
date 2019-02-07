<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     */
    public function indexAction()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['dateAdded'=> 'desc',]);
//            ->findBy([], ['viewCount' => 'desc', 'dateAdded'=> 'desc']);
        return $this->render('home/index.html.twig',
            ['articles' => $articles]);
    }
}
