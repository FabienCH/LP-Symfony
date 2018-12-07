<?php

namespace mi06\VitrineBundle\Entity;

/**
 * Panier
 */
class Panier
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $contenu;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param array $contenu
     *
     * @return Panier
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return array
     */
    public function getContenu()
    {
        return $this->contenu;
    }
    
    public function ajoutArticle ($articleId, $qte = 1) {
    // ajoute l'article $articleId au contenu, en quantité $qte
    // (vérifier si l'article n'y est pas déjà)
        if(isset($this->contenu[$articleId])) {
            $this->contenu[$articleId] += $qte;
        }
        else {
            $this->contenu[$articleId] = $qte;
        }
    }
    
    public function supprimeArticle($articleId) {
    // supprimer l'article $articleId du contenu
        unset($this->contenu[$articleId]);
    }
    
    public function viderPanier() {
        $this->contenu = [];
    }
}

