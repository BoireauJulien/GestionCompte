<?php
namespace OC\PlatformBundle\Services\Types;

class TypeMCY
{
    private $montant;
    private $libelleAccount;
    private $categoryName;
    private $year;
    private $montantCredit;
    private $percent;
    
    public function __construct()
    {
        $this->montant = 0;
        $this->libelleAccount = '';
        $this->categoryName = '';
        $this->montantCredit = 0;
    }
    
    public function getMontant()
    {
        return $this->montant;
    }
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }
    public function addMontant($montant)
    {
        $this->montant += $montant;
    }
    
    public function getLibelleAccount()
    {
        return $this->libelleAccount;
    }
    public function setLibelleAccount($libelle)
    {
        $this->libelleAccount = $libelle;
    }
    
    public function getCategoryName()
    {
        return $this->categoryName;
    }
    public function setCategoryName($category)
    {
        $this->categoryName = $category;
    }
    
    public function getYear()
    {
        return $this->year;
    }
    public function setYear($year)
    {
        $this->year = $year;
    }
    
    public function getMontantCredit()
    {
        return $this->montantCredit;
    }
    public function setMontantCredit($montant)
    {
        $this->montantCredit = $montant;
    }
    public function addMontantCredit($montant)
    {
        $this->montantCredit += $montant;
    }
    
    public function getPercent()
    {
        return $this->percent;
    }
    public function calculPercent()
    {
        $percent = 0;
        if($this->montantCredit != 0){
            $percent = (-$this->montant * 100) / $this->montantCredit;
        } else {
            $percent = 100;
        }
        $this->percent = $percent;
    }
    
    public function isEqual(TypeMCY $typeMCY)
    {
        $isEqual = false;
        if($this->categoryName == $typeMCY->getCategoryName() &&
            $this->libelleAccount == $typeMCY->getLibelleAccount() &&
            $this->montant == $typeMCY->getMontant() &&
            $this->year == $typeMCY->getYear()){
                $isEqual = true;
        }
        return $isEqual;
    }
}