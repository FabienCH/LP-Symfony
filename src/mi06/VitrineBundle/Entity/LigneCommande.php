<?php

namespace mi06\VitrineBundle\Entity;

/**
 * LigneCommande
 */
class LigneCommande
{
    /**
     * @var string
     */
    private $articlePrix;

    /**
     * @var integer
     */
    private $quantite;

    /**
     * @var \mi06\VitrineBundle\Entity\Commande
     */
    private $commande;


    /**
     * Set articlePrix
     *
     * @param string $articlePrix
     *
     * @return LigneCommande
     */
    public function setArticlePrix($articlePrix)
    {
        $this->articlePrix = $articlePrix;

        return $this;
    }

    /**
     * Get articlePrix
     *
     * @return string
     */
    public function getArticlePrix()
    {
        return $this->articlePrix;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return LigneCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set commande
     *
     * @param \mi06\VitrineBundle\Entity\Commande $commande
     *
     * @return LigneCommande
     */
    public function setCommande(\mi06\VitrineBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \mi06\VitrineBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
    /**
     * @var \mi06\VitrineBundle\Entity\Article
     */
    private $article;


    /**
     * Set article
     *
     * @param \mi06\VitrineBundle\Entity\Article $article
     *
     * @return LigneCommande
     */
    public function setArticle(\mi06\VitrineBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \mi06\VitrineBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
