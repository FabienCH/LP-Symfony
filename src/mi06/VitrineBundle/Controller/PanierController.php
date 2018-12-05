<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use mi06\VitrineBundle\Entity\Panier;

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
}
