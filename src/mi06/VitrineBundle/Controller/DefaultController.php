<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Find and display articles in homepage.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('mi06VitrineBundle:Article')->findBy(array(), array(),9);
        return $this->render('mi06VitrineBundle:Default:index.html.twig',
            array('articles' => $articles));
    }
    
    /**
     * Find and display categories.
     *
     */
    public function catalogueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('mi06VitrineBundle:ArticleCategorie')->findAll();
        return $this->render('mi06VitrineBundle:Default:catalogue.html.twig',
            array('categories' => $categories));
    }
    
    /**
     * Find and display articles from a category.
     *
     * @param int $id The id of a category
     */
    public function articlesParCategorieAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('mi06VitrineBundle:ArticleCategorie')->find($id);
        $articles = $em->getRepository('mi06VitrineBundle:Article')->findByArticleCategorie($categorie);
        return $this->render('mi06VitrineBundle:Default:articlesParCategorie.html.twig',
            array('categorie' => $categorie,
                'articles' => $articles));
    }
    
    /**
     * Display legal notice.
     *
     */
    public function mentionsAction()
    {
        return $this->render('mi06VitrineBundle:Default:mentions.html.twig');
    }

    /**
     * Change local Language.
     *
     * @param Request $request The HHTP request
     * @param string $newLocal The new local to set
     */
    public function setLocalAction(Request $request, string $newLocal)
    {
        return $this->redirectToRoute('mi06_vitrine_homepage', array(
            '_locale' => $newLocal,
        ));
    }
}
