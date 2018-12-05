<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('mi06VitrineBundle:Default:index.html.twig',
            array('name' => $name));
    }
    
    public function catalogueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('mi06VitrineBundle:ArticleCategorie')->findAll();
        return $this->render('mi06VitrineBundle:Default:catalogue.html.twig',
            array('categories' => $categories));
    }
    
    public function articlesParCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('mi06VitrineBundle:ArticleCategorie')->find($id);
        $articles = $em->getRepository('mi06VitrineBundle:Article')->findByArticleCategorie($categorie);
        return $this->render('mi06VitrineBundle:Default:articlesParCategorie.html.twig',
            array('categorie' => $categorie,
                'articles' => $articles));
    }
    
    public function mentionsAction()
    {
        return $this->render('mi06VitrineBundle:Default:mentions.html.twig');
    }
}
