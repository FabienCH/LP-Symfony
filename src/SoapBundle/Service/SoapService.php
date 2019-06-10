<?php

namespace SoapBundle\Service;

use mi06\VitrineBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;

/**
 * Soap service.
 *
 */
class SoapService
{
    private $em;
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Finds and return a random article.
     * @return mi06\VitrineBundle\Entity\Article Random article
     */
    public function randomArticle()
    {
        $articles =  $this->em->getRepository('mi06VitrineBundle:Article')->findAll();
        $id = rand(0, count($articles) - 1);
        return $articles[$id];
    }

    /**
     * Finds and return the most sold articles.
     *
     * @param int $max The number of artcile to display
     * @return array Top 3 articles
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
        return $topArticles;  
    }
}
