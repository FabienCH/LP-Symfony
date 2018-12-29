<?php

namespace mi06\VitrineBundle\Controller;

use mi06\VitrineBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @param Request $request The HHTP request
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('mi06VitrineBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Lists all commande of a client.
     *
     * @param Request $request The HHTP request
     */
    public function mesCommandesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        if($session->has('clientId'))
        {
            $client = $em->getRepository('mi06VitrineBundle:Client')->find($session->get('clientId'));
            $commandes = $em->getRepository('mi06VitrineBundle:Commande')->findBy('client', $client);
        }
        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Finds and displays a commande entity.
     * 
     * @param Commande $commande The Commande entity
     */
    public function showAction(Commande $commande)
    {
        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @param Request $request The HHTP request
     * @param Commande $commande The Commande entity
     */
    public function editAction(Request $request, Commande $commande)
    {        
        $editForm = $this->createFormBuilder($commande)
        ->add('etat', TextType::class)
        ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
        ));
    }

}
