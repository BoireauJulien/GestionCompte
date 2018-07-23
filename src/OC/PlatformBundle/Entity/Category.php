<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\LigneCompte", mappedBy="category")
     */
    private $ligneComptes;
    
    /**
     * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
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
     * @ORM\Column(name="catName", type="string", length=255)
     */
    private $catName;
    
    public function __construct()
    {
        $this->ligneComptes = new ArrayCollection();
    }
    
    public function addLigneCompte(LigneCompte $ligneCompte)
    {
        $this->ligneComptes[] = $ligneCompte;
        
        $ligneCompte->setCategory($this);
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
     * Set catName
     *
     * @param string $catName
     *
     * @return Category
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;

        return $this;
    }

    /**
     * Get catName
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->catName;
    }

    /**
     * Set user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return Category
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
}
