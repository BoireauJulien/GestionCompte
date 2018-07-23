<?php
namespace OC\PlatformBundle\Services;


use OC\PlatformBundle\Services\Types\TypeMD;
use OC\PlatformBundle\Services\Types\TypeMM;
use OC\PlatformBundle\Services\Types\TypeMY;
use OC\PlatformBundle\Services\Types\TypeMC;
use OC\PlatformBundle\Services\Types\TypeMCY;

class CompteRenduOperation
{
    public function getMontantByDate($arrayLignesCompte)
    {
        $arraysTypeMD = array();
        for( $i = 0; $i < count($arrayLignesCompte); $i++){
            $arrayTypeMD = array();
            for($j = 0; $j < count($arrayLignesCompte[$i]); $j++){
                $typeMD = new TypeMD();
                $typeMD->setDate($arrayLignesCompte[$i][$j]->getDateOp());
                $typeMD->setMontant($arrayLignesCompte[$i][$j]->getMontant());
                $typeMD->setLibelleCompte($arrayLignesCompte[$i][$j]->getCompte()->getAccountName());
                for($k = 0; $k < count($arrayLignesCompte[$i]); $k++){
                    if($j != $k && $arrayLignesCompte[$i][$k]->getDateOp() == $typeMD->getDate()){
                        $typeMD->addMontant($arrayLignesCompte[$i][$k]->getMontant());
                    }
                }
                
                $isIn = false;
                for($h = 0; $h < count($arrayTypeMD); $h++){
                    if($typeMD->isEqual($arrayTypeMD[$h])){
                        $isIn = true;
                    }
                }
                if(!$isIn){
                    array_push($arrayTypeMD, $typeMD);
                }
            }
            array_push($arraysTypeMD, $arrayTypeMD);
        }
        
        
        
        return $arraysTypeMD;
    }
    
    public function getMontantByMonth($arraysLC)
    {
        $arraysTypeMM = array();
        for($i = 0; $i < count($arraysLC); $i++){
            $arrayTypeMM = array();
            for($j = 0; $j < count($arraysLC[$i]); $j++){
                $typeMM = new TypeMM();
                $month = $this->getMonthFromDate($arraysLC[$i][$j]->getDateOp());
                $typeMM->setAccount($arraysLC[$i][$j]->getCompte()->getAccountName());
                $typeMM->setMonth($month);
                if($arraysLC[$i][$j]->getIsDebit()){
                    $typeMM->setMontantDebit($arraysLC[$i][$j]->getMontant());
                } else {
                    $typeMM->setMontantCredit($arraysLC[$i][$j]->getMontant());
                }
                for($k = 0; $k < count($arraysLC[$i]); $k++){
                    $monthK = $this->getMonthFromDate($arraysLC[$i][$k]->getDateOp());
                    if($k != $j && $monthK == $month){
                        if($arraysLC[$i][$k]->getIsDebit()){
                            $typeMM->addMontantDebit($arraysLC[$i][$k]->getMontant());
                        } else {
                            $typeMM->addMontantCredit($arraysLC[$i][$k]->getMontant());
                        }
                    }
                }
                
                $isIn = false;
                for($h = 0; $h < count($arrayTypeMM); $h++){
                    if($typeMM->isEqual($arrayTypeMM[$h])){
                        $isIn = true;
                    }
                }
                if(!$isIn){
                    $typeMM->setMontantCD();
                    array_push($arrayTypeMM, $typeMM);
                }
            }
            array_push($arraysTypeMM, $arrayTypeMM);
        }
        
        return $arraysTypeMM;
    }
    
    public function getMontantByYear($arraysLC)
    {
        $arraysTypeMY = array();
        for($i = 0; $i < count($arraysLC); $i++){
            $arrayTypeMY = array();
            for($j = 0; $j < count($arraysLC[$i]); $j++){
                $typeMY = new TypeMY();
                $typeMY->setYear($arraysLC[$i][$j]->getYear());
                $typeMY->setAccount($arraysLC[$i][$j]->getCompte()->getAccountName());
                if($arraysLC[$i][$j]->getIsDebit()){
                    $typeMY->setMontantDebit($arraysLC[$i][$j]->getMontant());
                } else {
                    $typeMY->setMontantCredit($arraysLC[$i][$j]->getMontant());
                }
                for($k = 0; $k < count($arraysLC[$i]); $k++){
                    if($typeMY->getYear() == $arraysLC[$i][$k]->getYear() && $j != $k){
                        if($arraysLC[$i][$k]->getIsDebit()){
                            $typeMY->addMontantDebit($arraysLC[$i][$k]->getMontant());
                        } else {
                            $typeMY->addMontantCredit($arraysLC[$i][$k]->getMontant());
                        }
                    }
                }
                $isIn = false;
                for($h = 0; $h < count($arrayTypeMY); $h++){
                    if($typeMY->isEqual($arrayTypeMY[$h])){
                        $isIn = true;
                    }
                }
                if(!$isIn){
                    $typeMY->setTotalMontant();
                    array_push($arrayTypeMY, $typeMY);
                }
            }
            array_push($arraysTypeMY, $arrayTypeMY);
        }
        return $arraysTypeMY;
    }
    
    public function getMontantByCategoryAndMonth($arraysLC)
    {
        $arraysTypeMC = array();
        for ($i = 0; $i < count($arraysLC); $i++){
            $arrayTypeMC = array();
            for($j = 0; $j < count($arraysLC[$i]); $j++){
                $typeMC = new TypeMC();
                $typeMC->setLibelleAccount($arraysLC[$i][$j]->getCompte()->getAccountName());
                $category = $arraysLC[$i][$j]->getCategory()->getCatName();
                $montant = $arraysLC[$i][$j]->getMontant();
                $monthYear = $arraysLC[$i][$j]->getMonthYear();
                $typeMC->setCategoryName($category);
                $typeMC->setMonthYear($monthYear);
                if($arraysLC[$i][$j]->getYear() == date('Y', time())){
                    if($arraysLC[$i][$j]->getIsDebit()){
                        $typeMC->setMontant($montant);
                    } else {
                        $typeMC->setMontantCredit($montant);
                    }
                }
                for($k = 0; $k < count($arraysLC[$i]); $k++){
                    if($arraysLC[$i][$k]->getYear() == date('Y', time())){
                        if($category == $arraysLC[$i][$k]->getCategory()->getCatName() &&
                            $j != $k &&
                            $monthYear == $arraysLC[$i][$k]->getMonthYear()){
                                if($arraysLC[$i][$k]->getIsDebit()){
                                    $typeMC->addMontant($arraysLC[$i][$k]->getMontant());
                                }
                        }
                        if($j != $k &&
                            $monthYear == $arraysLC[$i][$k]->getMonthYear() &&
                            !$arraysLC[$i][$k]->getIsDebit()){
                                $typeMC->addMontantCredit($arraysLC[$i][$k]->getMontant());
                        }
                    }
                }
                $isIn = false;
                for($h = 0; $h < count($arrayTypeMC); $h++){
                    if($typeMC->isEqual($arrayTypeMC[$h])){
                        $isIn = true;
                    }
                }
                if(!$isIn){
                    if($typeMC->getMontant() < 0){
                        $typeMC->calculPercent();
                        array_push($arrayTypeMC, $typeMC);
                    }
                }
            }
            array_push($arraysTypeMC, $arrayTypeMC);
        }
        return $arraysTypeMC;
    }
    
    public function getMontantByCategoryAndYear($arraysLC)
    {
        $arraysTypeMCY = array();
        for($i = 0; $i < count($arraysLC); $i++){
            $arrayTypeMCY = array();
            for($j = 0; $j < count($arraysLC[$i]); $j++){
                $typeMCY = new TypeMCY();
                $year = $arraysLC[$i][$j]->getYear();
                $category = $arraysLC[$i][$j]->getCategory()->getCatName();
                $montant = $arraysLC[$i][$j]->getMontant();
                $typeMCY->setLibelleAccount($arraysLC[$i][$j]->getCompte()->getAccountName());
                $typeMCY->setYear($year);
                $typeMCY->setCategoryName($category);
                if($arraysLC[$i][$j]->getIsDebit()){
                    $typeMCY->setMontant($montant);
                } else {
                    $typeMCY->setMontantCredit($montant);
                }
                for($k = 0; $k < count($arraysLC[$i]); $k++){
                    if($year == $arraysLC[$i][$k]->getYear() &&
                        $j != $k &&
                        $category == $arraysLC[$i][$k]->getCategory()->getCatName() &&
                        $arraysLC[$i][$k]->getIsDebit()){
                        $typeMCY->addMontant($arraysLC[$i][$k]->getMontant());
                    }
                    if($j != $k &&
                        !$arraysLC[$i][$k]->getIsDebit() &&
                        $year == $arraysLC[$i][$k]->getYear()){
                        $typeMCY->addMontantCredit($arraysLC[$i][$k]->getMontant());
                    }
                }
                $isIn = false;
                for($h = 0; $h < count($arrayTypeMCY); $h++){
                    if($typeMCY->isEqual($arrayTypeMCY[$h])){
                        $isIn = true;
                    }
                }
                if(!$isIn){
                    if($typeMCY->getMontant() < 0){
                        $typeMCY->calculPercent();
                        array_push($arrayTypeMCY, $typeMCY);
                    }
                }
            }
            array_push($arraysTypeMCY, $arrayTypeMCY);
        }
        return $arraysTypeMCY;
    }
    
    public function getMonthFromDate($date)
    {
        $dateStr =$date->format('Y-m-d');
        $arrayDate = explode('-', $dateStr);
        $month = date("n", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        return $month;
    }
    
}
