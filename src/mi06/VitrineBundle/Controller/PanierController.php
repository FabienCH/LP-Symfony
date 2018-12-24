<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use mi06\VitrineBundle\Entity\Panier;
use mi06\VitrineBundle\Entity\LigneCommande;
use mi06\VitrineBundle\Entity\Commande;
use mi06\VitrineBundle\Service\MontantPanier;

class PanierController extends Controller
{   
    public function contenuPanierAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $montantPanierService = $this->get('montant_panier');
            $panier = $session->get('panier');
            $totalPanier = $montantPanierService->getMontant($panier);
            $articles = $montantPanierService->getArticles($panier);
            
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
            $montantPanierService = $this->get('montant_panier');
            $panier = $session->get('panier');
            $totalPanier = $montantPanierService->getMontant($panier);
            
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
