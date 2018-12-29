<?php

namespace mi06\VitrineBundle\Controller;

use mi06\VitrineBundle\Entity\ArticleCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Articlecategorie controller.
 *
 */
class ArticleCategorieController extends Controller
{
    /**
     * Lists all articleCategorie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articleCategories = $em->getRepository('mi06VitrineBundle:ArticleCategorie')->findAll();

        return $this->render('articlecategorie/index.html.twig', array(
            'articleCategories' => $articleCategories,
        ));
    }

    /**
     * Creates a new articleCategorie entity.
     *
     * @param Request $request The HHTP request
     */
    public function newAction(Request $request)
    {
        $articleCategorie = new Articlecategorie();
        $form = $this->createForm('mi06\VitrineBundle\Form\ArticleCategorieType', $articleCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($articleCategorie);
            $em->flush();

            return $this->redirectToRoute('articlecategorie_show', array('id' => $articleCategorie->getId()));
        }

        return $this->render('articlecategorie/new.html.twig', array(
            'articleCategorie' => $articleCategorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a articleCategorie entity.
     *
     * @param ArticleCategorie $articleCategorie The articleCategorie entity
     */
    public function showAction(ArticleCategorie $articleCategorie)
    {
        $deleteForm = $this->createDeleteForm($articleCategorie);

        return $this->render('articlecategorie/show.html.twig', array(
            'articleCategorie' => $articleCategorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing articleCategorie entity.
     *
     * @param Request $request The HHTP request
     * @param ArticleCategorie $articleCategorie The articleCategorie entity
     */
    public function editAction(Request $request, ArticleCategorie $articleCategorie)
    {
        $deleteForm = $this->createDeleteForm($articleCategorie);
        $editForm = $this->createForm('mi06\VitrineBundle\Form\ArticleCategorieType', $articleCategorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articlecategorie_edit', array('id' => $articleCategorie->getId()));
        }

        return $this->render('articlecategorie/edit.html.twig', array(
            'articleCategorie' => $articleCategorie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a articleCategorie entity.
     *
     * @param Request $request The HHTP request
     * @param ArticleCategorie $articleCategorie The articleCategorie entity
     */
    public function deleteAction(Request $request, ArticleCategorie $articleCategorie)
    {
        $form = $this->createDeleteForm($articleCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($articleCategorie);
            $em->flush();
        }

        return $this->redirectToRoute('articlecategorie_index');
    }

    /**
     * Creates a form to delete a articleCategorie entity.
     *
     * @param ArticleCategorie $articleCategorie The articleCategorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ArticleCategorie $articleCategorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articlecategorie_delete', array('id' => $articleCategorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
