<?php

namespace mi06\VitrineBundle\Entity;

/**
 * Commande
 */
class Commande
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $etat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneCommande;

    /**
     * @var \mi06\VitrineBundle\Entity\Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ligneCommande = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Add ligneCommande
     *
     * @param \mi06\VitrineBundle\Entity\LigneCommande $ligneCommande
     *
     * @return Commande
     */
    public function addLigneCommande(\mi06\VitrineBundle\Entity\LigneCommande $ligneCommande)
    {
        $this->ligneCommande[] = $ligneCommande;

        return $this;
    }

    /**
     * Remove ligneCommande
     *
     * @param \mi06\VitrineBundle\Entity\LigneCommande $ligneCommande
     */
    public function removeLigneCommande(\mi06\VitrineBundle\Entity\LigneCommande $ligneCommande)
    {
        $this->ligneCommande->removeElement($ligneCommande);
    }

    /**
     * Get ligneCommande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLigneCommande()
    {
        return $this->ligneCommande;
    }

    /**
     * Set client
     *
     * @param \mi06\VitrineBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function setClient(\mi06\VitrineBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \mi06\VitrineBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
