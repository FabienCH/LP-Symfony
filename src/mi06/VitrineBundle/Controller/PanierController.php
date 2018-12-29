<?php

namespace mi06\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use mi06\VitrineBundle\Entity\Panier;
use mi06\VitrineBundle\Service\PanierService;

class PanierController extends Controller
{   
    /**
     * Get and display basket content.
     *
     * @param Request $request The HHTP request
     */
    public function contenuPanierAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panierService = $this->get('panier_service');
            $panier = $session->get('panier');
            $totalPanier = $panierService->getMontant($panier);
            $articles = $panierService->getArticles($panier);
            
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
    
    /**
     * Get and display basket content on the side.
     *
     * @param Request $request The HHTP request
     */
    public function contenuPanierAsideAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panierService = $this->get('panier_service');
            $panier = $session->get('panier');
            $totalPanier = $panierService->getMontant($panier);
            
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
    
    /**
     * Add an article in the basket.
     *
     * @param Request $request The HHTP request
     * @param int $idArticle The id of the article to add
     * @param int $quantite The quantity to add
     */
    public function ajoutArticleAction(Request $request, int $idArticle, int $quantite)
    {
        $panier = new Panier;
        $session = $request->getSession();
        if($session->has('panier'))
        {
            $panier = $session->get('panier');
        } 
        $panier->ajoutArticle($idArticle, $quantite);
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('mi06VitrineBundle:Article')->find($idArticle);
        $article->setStock($article->getStock() - 1);
        $em->flush();
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('mi06_panier'));
    }
 
    /**
     * Empty the basket.
     *
     * @param Request $request The HHTP request
     */
    public function viderPanierAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panier = $session->get('panier');
            $panierService = $this->get('panier_service');
            $panierService->updateStock($panier);     
        }
        $panier = new Panier;
        $panier->viderPanier();
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('mi06_vitrine_homepage'));
    }
    
    /**
     * Validate the basket and pass order.
     *
     * @param Request $request The HHTP request
     */
    public function validationPanierAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has('panier') && !empty($session->get('panier')->getContenu()))
        {
            $panier = $session->get('panier');
            $panierService = $this->get('panier_service');
            $commande =  $panierService->passerCommande($this->getUser(), $panier);
            return $this->render('mi06VitrineBundle:Panier:validationPanier.html.twig',
                array('commande' => $commande));
         
        }
        else {
            return $this->redirect($this->generateUrl('mi06_panier'));
        }
    }
}
