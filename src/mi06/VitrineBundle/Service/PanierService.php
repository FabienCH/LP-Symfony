<?php

namespace mi06\VitrineBundle\Service;

use mi06\VitrineBundle\Entity\Commande;
use mi06\VitrineBundle\Entity\LigneCommande;

class PanierService {
    private $em;
    public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
    }
    /**
    * Calcul et return the total cost of the basket
    *
    * @param Panier $panier The basket
    * @return int The total cost of the basket
    */
    public function getMontant(\mi06\VitrineBundle\Entity\Panier $panier) {
        $totalPanier = 0;
        $articles = [];
        foreach($panier->getContenu() as $idArticle => $quantite) {
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
            $totalPanier += $article->getPrix() * $quantite;        
        }
        return $totalPanier;
    }

    /**
    * Return articles of the basket
    *
    * @param Panier $panier The basket
    * @return Array A list of articles
    */
    public function getArticles(\mi06\VitrineBundle\Entity\Panier $panier) {
        $totalPanier = 0;
        $articles = [];
        foreach($panier->getContenu() as $idArticle => $quantite) {
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
            array_push($articles, $article);
        }
        return $articles;
    }

    /**
    * Add quantity of articles in a basket to the stock when a basket is emptied
    *
    * @param Panier $panier The basket
    */
    public function updateStock(\mi06\VitrineBundle\Entity\Panier $panier) {
        foreach($panier->getContenu() as $idArticle => $quantite) {
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
            $article->setStock($article->getStock() + $quantite);
            $this->em->flush();
        }
    }

    /**
    * Build and pass order 
    *
    * @param Panier $panier The basket
    * @return Commande The order
    */
    public function passerCommande(\mi06\VitrineBundle\Entity\Client $client, \mi06\VitrineBundle\Entity\Panier $panier) {
        $commande = new Commande();
        $commande->setClient($client);
        foreach ($panier->getContenu() as $articleId => $quantite) {
            $ligneCommande = new LigneCommande();
            $article = $this->em->getRepository('mi06VitrineBundle:Article')->find($articleId);
            $ligneCommande->setArticlePrix($article->getPrix());
            $ligneCommande->setQuantite($quantite);
            $ligneCommande->setArticle($article);
            $ligneCommande->setCommande($commande);
            $commande->addLigneCommande($ligneCommande);
            $commande->setDate(new \DateTime('now'));
            $commande->setEtat('en cours de préparation');
            $this->em->persist($ligneCommande);
            $article->setStock($article->getStock() - $quantite);
        }
        $this->em->persist($commande);
        $this->em->flush();
        $panier->viderPanier();
        return $commande;
    }
}