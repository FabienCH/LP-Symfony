<?php

namespace SoapBundle\Service;

use mi06\VitrineBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Soap service.
 *
 */
class SoapService
{

    /**
     * Finds and return a random article.
     *
     */
    public function artcileRandom()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('mi06VitrineBundle:Article')->findAll();
        $id = rand(0, count($topArticles) - 1);
        return $articles[$id];   
    }

    /**
     * Finds and return the most sold articles.
     *
     * @param int $max The number of artcile to display
     */
    public function articlePlusVendus($max = 3)
    {
        $em = $this->getDoctrine()->getRepository('mi06VitrineBundle:LigneCommande');
        $topArticlesQuantite = $em->topArticlesQuantite($max);
        $topArticles = [];
        $em = $this->getDoctrine()->getManager();
         foreach($topArticlesQuantite as $topArticleQuantite) {
            array_push($topArticles, $em->getRepository('mi06VitrineBundle:Article')->find($topArticleQuantite["articleId"]));
        }
        return json_encode(array('topArticlesQuantite' => $topArticlesQuantite, 'topArticles' => $topArticles));   
    }
}
