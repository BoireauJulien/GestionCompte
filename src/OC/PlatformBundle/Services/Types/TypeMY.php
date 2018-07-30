<?php
namespace OC\PlatformBundle\Services\Types;

class TypeMY
{
    private $montantDebit = 0;
    private $montantCredit = 0;
    private $totalMontant = 0;
    private $year;
    private $account;
    
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
    
    public function getTotalMontant()
    {
        return $this->totalMontant;
    }
    
    public function setTotalMontant()
    {
        $this->totalMontant = $this->montantCredit + $this->montantDebit;
    }
    
    public function getYear()
    {
        return $this->year;
    }
    
    public function setYear($year)
    {
        $this->year = $year;
    }
    
    public function getAccount()
    {
        return $this->account;
    }
    
    public function setAccount($name)
    {
        $this->account = $name;
    }
    
    public function isEqual(TypeMY $typeMY)
    {
        $isEqual = false;
        if($this->account == $typeMY->getAccount() &&
            (number_format($this->montantCredit, 2) == number_format($typeMY->getMontantCredit(), 2) 
                || number_format($this->montantDebit, 2) == number_format($typeMY->getMontantDebit(), 2)) &&
            $this->year == $typeMY->getYear()){
            $isEqual = true;
        }
        return $isEqual;
    }
}