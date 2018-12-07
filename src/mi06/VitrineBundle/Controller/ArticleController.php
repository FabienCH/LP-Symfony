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
        $em = $this->getDoctrine()->getRepository('mi06VitrineBundle:LigneCommande');
        $topArticlesQuantite = $em->topArticlesQuantite($max);
        $topArticles = [];
        $em = $this->getDoctrine()->getManager();
         foreach($topArticlesQuantite as $topArticleQuantite) {
            array_push($topArticles, $em->getRepository('mi06VitrineBundle:Article')->find($topArticleQuantite["articleId"]));
        }
        return $this->render('mi06VitrineBundle:Article:plusVendus.html.twig',
        array('topArticlesQuantite' => $topArticlesQuantite,
            'topArticles' => $topArticles));
         
    }
}