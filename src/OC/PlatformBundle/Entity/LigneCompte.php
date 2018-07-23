<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCompte
 *
 * @ORM\Table(name="ligne_compte")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\LigneCompteRepository")
 */
class LigneCompte
{
    /**
     * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Category", inversedBy="ligneComptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Compte", inversedBy="ligneComptes")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    private $compte;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOp", type="date")
     */
    private $dateOp;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="monthYear", type="integer")
     */
    private $monthYear;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=255)
     */
    private $detail;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=2)
     */
    private $montant;
    
    /**
     * @var boolean
     * @ORM\Column(name="isDebit", type="boolean")
     *
     */
    private $isDebit;
    
    public function __construct()
    {
        
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
     * Set dateOp
     *
     * @param \DateTime $dateOp
     *
     * @return LigneCompte
     */
    public function setDateOp($dateOp)
    {
        $this->dateOp = $dateOp;

        return $this;
    }

    /**
     * Get dateOp
     *
     * @return \DateTime
     */
    public function getDateOp()
    {
        return $this->dateOp;
    }

    /**
     * Set detail
     *
     * @param string $detail
     *
     * @return LigneCompte
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return LigneCompte
     */
    public function setMontant($montant)
    {
        
        if($this->getIsDebit()){
            $this->montant = -$montant;
        }else {
            $this->montant = $montant;
        }

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }
    
    public function setCategory(Category $category)
    {
        $this->category = $category;
        
        return $this;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setCompte(Compte $compte)
    {
        $this->compte = $compte;
        return $this;
    }
    
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set isDebit
     *
     * @param boolean $isDebit
     *
     * @return LigneCompte
     */
    public function setIsDebit($isDebit)
    {
        $this->isDebit = $isDebit;

        return $this;
    }

    /**
     * Get isDebit
     *
     * @return boolean
     */
    public function getIsDebit()
    {
        return $this->isDebit;
    }

    /**
     * Set monthYear.
     *
     * @param int $monthYear
     *
     * @return LigneCompte
     */
    public function setMonthYear($monthYear)
    {
        $this->monthYear = $monthYear;

        return $this;
    }

    /**
     * Get monthYear.
     *
     * @return int
     */
    public function getMonthYear()
    {
        return $this->monthYear;
    }

    /**
     * Set year.
     *
     * @param int $year
     *
     * @return LigneCompte
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
}
