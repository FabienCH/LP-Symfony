<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ArticleController
 *
 * @author Fabien
 */
class ArticleController extends Controller
{
    public function plusVendusAction($max = 3)
    {
        // rechercher en BD les "$max" articles les plus vendus
        /*
        $articles = [];
        $topArticles = [];
        $em = $this->getDoctrine()->getManager();
        $lignesCommande = $em->getRepository('mi06VitrineBundle:LigneCommande')->findAll();
        foreach($lignesCommande as $ligneCommande) {
            $articleId = $ligneCommande->getArticle()->getid();
            if(!isset($articles[$articleId])) {
                $articles[$articleId] = $ligneCommande->getQuantite();
            }
            else {
                $articles[$articleId] += $ligneCommande->getQuantite();
            }
        }
        rsort($articles);
        dump($articles);
        $articlesQuantite = array_slice($articles, 0, 3);
        foreach($articlesQuantite as $articleId => $quantite) {
            array_push($topArticles, $em->getRepository('mi06VitrineBundle:Article')->find($articleId));
        }
        dump($topArticles);
        dump($articlesQuantite);
        return $this->render('mi06VitrineBundle:Article:plusVendus.html.twig',
        array('articlesQuantite' => $articlesQuantite,
            'articles' => $topArticles));
                */
        $em = $this->getDoctrine()->getRepository('mi06VitrineBundle:LigneCommande');
        $topArticlesQuantite = $em->topArticlesQuantite($max);
        dump($topArticlesQuantite);
        $topArticles = [];
        $em = $this->getDoctrine()->getManager();
         foreach($topArticlesQuantite as $topArticleQuantite) {
             dump($topArticleQuantite);
            array_push($topArticles, $em->getRepository('mi06VitrineBundle:Article')->find($topArticleQuantite["articleId"]));
        }
        return $this->render('mi06VitrineBundle:Article:plusVendus.html.twig',
        array('topArticlesQuantite' => $topArticlesQuantite,
            'topArticles' => $topArticles));
         
    }
}