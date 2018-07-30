<?php
namespace OC\PlatformBundle\Services\Types;

class TypeMD
{
    private $montant;
    private $libelleCompte;
    private $date;
    
    public function __construct()
    {
        $this->montant = 0;
        $this->date = new \DateTime();
        $this->libelleCompte = '';
    }
    
    public function getLibelleCompte()
    {
        return $this->libelleCompte;
    }
    
    public function setLibelleCompte($libelle)
    {
        $this->libelleCompte = $libelle;
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
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    public function isEqual(TypeMD $typeMD)
    {
        $isEqual = false;
        if(number_format($this->montant, 2) == number_format($typeMD->getMontant(),2) && $this->date == $typeMD->getDate()){
            $isEqual = true;
        }
        
       return $isEqual;
    }
    
    public function setValues(TypeMD $typeMD)
    {
        $this->montant = $typeMD->getMontant();
        $this->date = $typeMD->getDate();
    }
}