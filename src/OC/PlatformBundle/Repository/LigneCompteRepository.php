<?php

namespace OC\PlatformBundle\Repository;

use OC\PlatformBundle\Entity\Compte;
use OC\PlatformBundle\Entity\Category;



/**
 * LigneCompteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LigneCompteRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllLigneCompteByUser(Compte $compte)
    {
        $queryBuilder = $this->createQueryBuilder('lC');
        $queryBuilder->where('lC.compte = :compte')
                     ->setParameter('compte', $compte);
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function getAllLigneCompteFromCurrentYear(Compte $compte)
    {
        $date = date('Y-m-d', time());
        $arrayDate = explode('-', $date);
        $year = date("Y", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        
        $queryBuilder = $this->createQueryBuilder('lC');
        $queryBuilder->where('lC.year = :year')
                     ->andWhere('lC.compte = :compte')
                     ->setParameters(array(
                         'year' => $year,
                         'compte' => $compte
                     ));
        return $queryBuilder->getQuery()->getResult();
    }
   
    public function getAllLigneCompteFromCurrentMonth(Compte $compte){
        $date = date('Y-m-d', time());
        $monthYear = $this->getMonthYearFromDate($date);
        $queryBuilder = $this->createQueryBuilder('lC');
        $queryBuilder->where('lC.monthYear = :monthYear')
                     ->andWhere('lC.compte = :compte')
                     ->orderBy('lC.dateOp','ASC')
                     ->setParameters(array(
                         'monthYear'=> $monthYear,
                         'compte'=> $compte
                     ));
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function getMontants(Compte $compte)
    {
        $date = date('Y-m-d', time());
        $monthYear = $this->getMonthYearFromDate($date);
        $queryBuilder = $this->createQueryBuilder('lC');
        $queryBuilder->select('lC.montant')
        ->where('lC.monthYear = :monthYear')
        ->andWhere('lC.compte = :compte')
        ->setParameters(array(
            'monthYear' => $monthYear,
            'compte' => $compte
        ));
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function getAllLigneCompteByCategory(Compte $compte, Category $category)
    {
        $queryBuilder = $this->createQueryBuilder('lc');
        $queryBuilder->where('lc.compte = :compte')
                     ->andWhere('lc.category = :category')
                     ->orderBy('lc.dateOp', 'DESC')
                     ->setParameters(array(
                         'compte' => $compte,
                         'category' => $category
                     ));
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function getMonthYearFromDate($date)
    {
        $arrayDate = explode('-', $date);
        $month = date("n", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        $year = date("Y", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        $monthYear = $month.$year."";
        return intVal($monthYear);
    }
    
    public function getSolde(Compte $compte)
    {
        $montants = $this->getMontants($compte);
        $sInitial = $compte->getSoldeInitial();
        $solde = $sInitial;
        foreach($montants as $montant){
            foreach($montant as $m){
                $solde += floatval($m);
            }
        }
        
        return $solde;
    }
    
    public function getById(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('lC');
        $queryBuilder->where('lC.id = :id')
                     ->setParameter('id', $id);
        return $queryBuilder->getQuery()->getResult();
    }
    
}
