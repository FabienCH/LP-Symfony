<?php

namespace mi06\VitrineBundle\Entity;

/**
 * Article
 */
class Article
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var float
     */
    private $prix;

    /**
     * @var integer
     */
    private $stock;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneArticle;

    /**
     * @var \mi06\VitrineBundle\Entity\ArticleCategorie
     */
    private $articleCategorie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ligneArticle = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Article
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Add ligneArticle
     *
     * @param \mi06\VitrineBundle\Entity\LigneCommande $ligneArticle
     *
     * @return Article
     */
    public function addLigneArticle(\mi06\VitrineBundle\Entity\LigneCommande $ligneArticle)
    {
        $this->ligneArticle[] = $ligneArticle;

        return $this;
    }

    /**
     * Remove ligneArticle
     *
     * @param \mi06\VitrineBundle\Entity\LigneCommande $ligneArticle
     */
    public function removeLigneArticle(\mi06\VitrineBundle\Entity\LigneCommande $ligneArticle)
    {
        $this->ligneArticle->removeElement($ligneArticle);
    }

    /**
     * Get ligneArticle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLigneArticle()
    {
        return $this->ligneArticle;
    }

    /**
     * Set articleCategorie
     *
     * @param \mi06\VitrineBundle\Entity\ArticleCategorie $articleCategorie
     *
     * @return Article
     */
    public function setArticleCategorie(\mi06\VitrineBundle\Entity\ArticleCategorie $articleCategorie = null)
    {
        $this->articleCategorie = $articleCategorie;

        return $this;
    }

    /**
     * Get articleCategorie
     *
     * @return \mi06\VitrineBundle\Entity\ArticleCategorie
     */
    public function getArticleCategorie()
    {
        return $this->articleCategorie;
    }
}
