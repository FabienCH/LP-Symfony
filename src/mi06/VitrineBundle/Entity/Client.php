<?php

namespace mi06\VitrineBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Client
 */
class Client implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $administrateur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commande;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commande = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Client
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set administrateur
     *
     * @param string $administrateur
     */
    public function setAdministrateur($isAdministrateur)
    {
        $this->administrateur = $isAdministrateur;
    }

    /**
     * Is administrateur
     *
     * @return string
     */
    public function isAdministrateur()
    {
        return $this->administrateur;
    }

    /**
     * Add commande
     *
     * @param \mi06\VitrineBundle\Entity\Commande $commande
     *
     * @return Client
     */
    public function addCommande(\mi06\VitrineBundle\Entity\Commande $commande)
    {
        $this->commande[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \mi06\VitrineBundle\Entity\Commande $commande
     */
    public function removeCommande(\mi06\VitrineBundle\Entity\Commande $commande)
    {
        $this->commande->removeElement($commande);
    }

    /**
     * Get commande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommande()
    {
        return $this->commande;
    }
    
    public function __toString()
    { 
        return $this->getNom(); 
    }

    public function getUsername() {
        return $this->email; // l'email est utilisé comme login
    }

    public function getSalt() {
        return null; // inutile avec l’encryptage choisi
    }

    public function getRoles() {
        if ($this->isAdministrateur()) // Si le client est administrateur
        return array('ROLE_ADMIN'); // on lui accorde le rôle ADMIN
        else
        return array('ROLE_USER'); // sinon le rôle USER
    }

    public function eraseCredentials(){}

    public function serialize() { // pour pouvoir sérialiser le Client en session
        return serialize(array($this->id, $this->nom, $this->email, $this->password));
    }

    public function unserialize($serialized) {
        list ($this->id, $this->nom, $this->email, $this->password) = unserialize($serialized);
    }
}
