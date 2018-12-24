<?php

namespace mi06\VitrineBundle\Service;

class MontantPanier {
    private $em;
    public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
    }
    /**
    * Calcul et retourne le montant d'un panier
    *
    * @param Panier $panier
    * @return int
    */
    public function getMontant(\mi06\VitrineBundle\Entity\Panier $panier) {
        $totalPanier = 0;
        $articles = [];
        foreach($panier->getContenu() as $idArticle => $quantité) {
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
            $totalPanier += $article->getPrix() * $quantité;        
        }
        return $totalPanier;
    }

    /**
    * Retourne les articles d'un panier
    *
    * @param Panier $panier
    * @return Array
    */
    public function getArticles(\mi06\VitrineBundle\Entity\Panier $panier) {
        $totalPanier = 0;
        $articles = [];
        foreach($panier->getContenu() as $idArticle => $quantité) {
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
            array_push($articles, $article);
        }
        return $articles;
    }
}