<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    /**
     * @Route("/article/create", name="article_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            /** @var UploadedFile $file */
//            $file = $form->getData()->getImage();
//
//            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
//
//            try {
//                $file->move($this->getParameter('article_directory'),
//                    $fileName);
//            } catch (FileException $ex) {
//
//            }
//
//            $article->setImage($fileName);
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
//            $article->setViewCount(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this->render('article/create.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewArticle($id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

//        $article->setViewCount($article->getViewCount() + 1);
        $article->setTitle($article->getTitle());
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return $this->render("article/article.html.twig",
            ['article' => $article]);
    }



}
