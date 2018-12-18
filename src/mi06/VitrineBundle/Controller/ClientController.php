<?php

namespace mi06\VitrineBundle\Controller;

use mi06\VitrineBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{


    /**
     * Creates a new client entity.
     *
     */
    public function loginAction(Request $request)
    {
        $client = new Client();
        $newClient = $this->createForm('mi06\VitrineBundle\Form\ClientType', $client);
        $newClient->handleRequest($request);
        if ($newClient->isSubmitted() && $newClient->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->persist($client);
            $em->flush();
            $session = $request->getSession();
            $session->set('clientId', $client->getId());
            return $this->redirectToRoute('/');
        }

        $login = $this->createFormBuilder($client)
            ->setAction($this->generateUrl('mi06_client_login'))
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();
        if ($login->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->getRepository('mi06VitrineBundle:Client')->findBy(
                array('name' => $client->getName(),
                    'password' => $client->getPassword())
                );
            $session = $request->getSession();
            $session->set('clientId', $client->getId());
            return $this->redirectToRoute('/');
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'newClient' => $newClient->createView(),
            'login' => $login->createView(),
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
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('mi06\VitrineBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
