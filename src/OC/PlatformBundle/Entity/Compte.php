<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Compte
 *
 * @ORM\Table(name="compte")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\LigneCompte", mappedBy="compte")
     */
    private $ligneComptes;
    
    /**
     * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User", inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    private $user;
    
    /**
     * @ORM\Column(name="soldeInitial", type="decimal", precision=10, scale=2)
     * 
     */
    private $soldeInitial;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="accountName", type="string", length=255, unique=true)
     */
    private $accountName;
    
    public function __construct()
    {
        $this->ligneComptes = new ArrayCollection();
    }

    public function addLigneCompte(LigneCompte $ligneCompte)
    {
        $this->ligneComptes[] = $ligneCompte;
        
        $ligneCompte->setCompte($this);
    }
    
    public function removeLigneCompte(LigneCompte $ligneCompte)
    {
        $this->ligneComptes->removeElement($ligneCompte);
    }
    
    public function getLigneComptes()
    {
        return $this->ligneComptes;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accountName
     *
     * @param string $accountName
     *
     * @return Compte
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Get accountName
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Set user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return Compte
     */
    public function setUser(\OC\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set soldeInitial.
     *
     * @param string $soldeInitial
     *
     * @return Compte
     */
    public function setSoldeInitial($soldeInitial)
    {
        $this->soldeInitial = $soldeInitial;

        return $this;
    }

    /**
     * Get soldeInitial.
     *
     * @return string
     */
    public function getSoldeInitial()
    {
        return $this->soldeInitial;
    }
}
