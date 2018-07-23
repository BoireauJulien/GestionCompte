<?php
namespace OC\PlatformBundle\Services\Types;

class TypeMC 
{
    private $montant;
    private $libelleAccount;
    private $categoryName;
    private $currentDate;
    private $monthYear;
    private $montantCredit;
    private $percent;
    
    public function __construct()
    {
        $this->montant = 0;
        $this->libelleAccount ='';
        $this->categoryName ='';
        $this->montantCredit = 0;
        $this->currentDate = date('Y-m-d', time());
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
    public function setCategoryName($name)
    {
        $this->categoryName = $name;
    }
    
    public function getCurrentDate()
    {
        return $this->currentDate;
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
    
    public function getMonthYear()
    {
        return $this->monthYear;
    }
    public function setMonthYear($monthYear)
    {
        $this->monthYear = $monthYear;
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
    
    public function isEqual(TypeMC $typeMC)
    {
        $isEqual = false;
        if($this->categoryName == $typeMC->getCategoryName() &&
            $this->libelleAccount == $typeMC->getLibelleAccount() &&
            $this->montant == $typeMC->getMontant() &&
            $this->monthYear == $typeMC->getMonthYear()){
            $isEqual = true;
        }
        return $isEqual;
    }
}