<?php

namespace mi06\VitrineBundle\Entity;

/**
 * ArticleCategorie
 */
class ArticleCategorie
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $intitule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $article;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->article = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return ArticleCategorie
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Add article
     *
     * @param \mi06\VitrineBundle\Entity\Article $article
     *
     * @return ArticleCategorie
     */
    public function addArticle(\mi06\VitrineBundle\Entity\Article $article)
    {
        $this->article[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \mi06\VitrineBundle\Entity\Article $article
     */
    public function removeArticle(\mi06\VitrineBundle\Entity\Article $article)
    {
        $this->article->removeElement($article);
    }

    /**
     * Get article
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticle()
    {
        return $this->article;
    }

    public function __toString() {
        return $this->getIntitule();
    }
}
