<?php

namespace mi06\VitrineBundle\Controller;

use mi06\VitrineBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{

    public function indexAction()
    {
        if($this->getUser()) {
            return $this->render('client/show.html.twig', array(
                'client' => $this->getUser()));
        }
        return $this->redirectToRoute('mi06_client_login');     
    }

    /**
     * Creates a new client entity.
     *
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render('client/index.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function createAction(Request $request)
    {
        $client = new Client();
        $newClientForm = $this->createForm('mi06\VitrineBundle\Form\ClientType', $client);
        $newClientForm->handleRequest($request);
        if ($newClientForm->isSubmitted() && $newClientForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->persist($client);
            $em->flush();
            $session = $request->getSession();
            $session->set('clientId', $client->getId());
            return $this->redirectToRoute('mi06_vitrine_homepage');
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'newClientForm' => $newClientForm->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     */
    public function editAction(Request $request, Client $client)
    {
        $editForm = $this->createFormBuilder($client)
        ->add('nom', TextType::class)
        ->add('email', TextType::class)
        ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a client entity.
     *
     */
    public function deleteAction(Request $request, Client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
