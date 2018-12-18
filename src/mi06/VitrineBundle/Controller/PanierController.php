<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use mi06\VitrineBundle\Entity\Panier;
use mi06\VitrineBundle\Entity\LigneCommande;
use mi06\VitrineBundle\Entity\Commande;

class PanierController extends Controller
{   
    public function contenuPanierAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panier = $session->get('panier');
            $totalPanier = 0;
            $articles = [];
            foreach($panier->getContenu() as $idArticle => $quantité) {
                $em = $this->getDoctrine()->getManager();
                $article = $em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
                array_push($articles, $article);
                $totalPanier += $article->getPrix() * $quantité; 
            }
            
            return $this->render('mi06VitrineBundle:Panier:contenuPanier.html.twig',
            array('panier' => $panier,
                'articles' => $articles,
                'totalPanier' => $totalPanier));
        }
        else {
            return $this->render('mi06VitrineBundle:Panier:contenuPanier.html.twig',
            array('panier' => null,
                'totalPanier' => null));
        }
    }
    
    public function contenuPanierAsideAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panier = $session->get('panier');
            $totalPanier = 0;
            foreach($panier->getContenu() as $idArticle => $quantité) {
                $em = $this->getDoctrine()->getManager();
                $article = $em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
                $totalPanier += $article->getPrix() * $quantité; 
            }
            
            return $this->render('mi06VitrineBundle:Panier:contenuPanierAside.html.twig',
            array('nbArticles' => count($panier->getContenu()),
                'totalPanier' => $totalPanier));
        }
        else {
            return $this->render('mi06VitrineBundle:Panier:contenuPanierAside.html.twig',
            array('nbArticles' => null,
                'totalPanier' => null));
        }
    }
    
    public function ajoutArticleAction(Request $request, int $idArticle, int $quantite)
    {
        $panier = new Panier;
        $session = $request->getSession();
        if($session->has('panier'))
        {
            $panier = $session->get('panier');
        }  
        $panier->ajoutArticle($idArticle, $quantite);
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('mi06_panier'));
    }
 
    public function viderPanierAction(Request $request)
    {
        $panier = new Panier;
        $session = $request->getSession();
        $panier->viderPanier();
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('mi06_panier'));
    }
    
    public function validationPanierAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('clientId', 1);
        if($session->has('panier') && $session->has('clientId') && !empty($session->get('panier')->getContenu()))
        {
            $em = $this->getDoctrine()->getManager();
            $panier = $session->get('panier');
            $commande = new Commande();
            $client = $em->getRepository('mi06VitrineBundle:Client')->find($session->get('clientId'));
            $commande->setClient($client);
            $em = $this->getDoctrine()->getManager();
            foreach ($panier->getContenu() as $articleId => $quantite) {
                $ligneCommande = new LigneCommande();
                $article = $em->getRepository('mi06VitrineBundle:Article')->find($articleId);
                $ligneCommande->setArticlePrix($article->getPrix());
                $ligneCommande->setQuantite($quantite);
                $ligneCommande->setArticle($article);
                $ligneCommande->setCommande($commande);
                $commande->addLigneCommande($ligneCommande);
                $commande->setDate(new \DateTime('now'));
                $commande->setEtat('en cours de préparation');
                $em->persist($ligneCommande);
            }
            $em->persist($commande);
            $em->flush();
            $panier->viderPanier();
            return $this->render('mi06VitrineBundle:Panier:validationPanier.html.twig',
                array('commande' => $commande));
         
        }
        else {
            return $this->redirect($this->generateUrl('mi06_panier'));
        }
    }
}
