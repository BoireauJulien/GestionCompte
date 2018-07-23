<?php
namespace OC\PlatformBundle\Services\Types;

class TypeMM
{
    private $account;
    private $montantDebit = 0;
    private $montantCredit = 0;
    private $montantCD;
    private $month;
    
    public function __construct()
    {
        
    }
    
    public function getAccount()
    {
        return $this->account;
    }
    
    public function setAccount($account)
    {
        $this->account = $account;
    }
    
    public function getMontantDebit()
    {
        return $this->montantDebit;
    }
    
    public function setMontantDebit($montant)
    {
        $this->montantDebit = $montant;
    }
    
    public function addMontantDebit($montant)
    {
        $this->montantDebit += $montant;
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
    
    public function getMonth()
    {
        return $this->month;
    }
    
    public function setMonth($month)
    {
        $this->month = $month;
    }
    
    public function getMontantCD()
    {
        return $this->montantCD;
    }
    
    public function setMontantCD()
    {
        $this->montantCD = $this->montantCredit + $this->montantDebit;
    }
    
    public function isEqual(TypeMM $typeMM)
    {
        $isEqual = false;
        if($this->month == $typeMM->getMonth() && 
            ($this->montantCredit == $typeMM->getMontantCredit() || $this->montantDebit == $typeMM->getMontantDebit()) &&
            $this->account == $typeMM->getAccount()){
            $isEqual = true;
        }
        return $isEqual;
    }
}