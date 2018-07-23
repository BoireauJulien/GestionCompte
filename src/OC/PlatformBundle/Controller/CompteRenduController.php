<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OC\PlatformBundle\Entity\Compte;
use OC\PlatformBundle\Entity\LigneCompte;
use OC\PlatformBundle\Services\CompteRenduOperation;

class CompteRenduController extends Controller
{
    private $bundleAndC = '@OCPlatform/Gestion/compteRendu/';
    public function debitDateAction()
    {
        $debitDateView = $this->bundleAndC . 'debitDate.html.twig';
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $repositoryLC = $em->getRepository(LigneCompte::class);
        $arrayLignesCompte = array();
        foreach($comptes as $compte){
            array_push($arrayLignesCompte, $repositoryLC->getAllLigneCompteByUser($compte));
        } 
        $CRO = new CompteRenduOperation();
        $arraysTypeMD = $CRO->getMontantByDate($arrayLignesCompte);
        
        return $this->render($debitDateView, array(
            'arraysTypeMD' => $arraysTypeMD
        ));
    }
    
    public function cdMoisAction()
    {
        $debitMoisView = $this->bundleAndC . 'debitMois.html.twig';
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $repositoryLC = $em->getRepository(LigneCompte::class);
        $arrayLignesCompte = array();
        foreach($comptes as $compte){
            array_push($arrayLignesCompte, $repositoryLC->getAllLigneCompteFromCurrentYear($compte));
        }
        
        $CRO = new CompteRenduOperation();
        $arraysTypeMM = $CRO->getMontantByMonth($arrayLignesCompte);
        return $this->render($debitMoisView, array(
            'arraysTypeMM' => $arraysTypeMM
        ));
    }
    
    public function depenseAnneeAction()
    {
        $depenseAnneeView = $this->bundleAndC . 'depenseAns.html.twig';
        $currentYear = date('Y', time());
        $CRO = new CompteRenduOperation();
        $arrayLignesCompte = $this->getArrayLigneCompte();
        $arraysTypeMY = $CRO->getMontantByYear($arrayLignesCompte);
        return $this->render($depenseAnneeView, array(
            "currentYear" => $currentYear,
            "arraysTypeMY" => $arraysTypeMY
        ));
    }
    
    public function debitCategoryAction()
    {
        $debitCategoryView = $this->bundleAndC . 'debitCategory.html.twig';
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $CRO = new CompteRenduOperation();
        $arrayLignesCompte = $this->getArrayLigneCompte();
        $arraysTypeMC = $CRO->getMontantByCategoryAndMonth($arrayLignesCompte);
        return $this->render($debitCategoryView, array(
            'arraysTypeMC' => $arraysTypeMC,
            'comptes' => $comptes
        ));
    }
    
    public function catAnneeAction()
    {
        $ratioCDView = $this->bundleAndC . 'depenseCatAnnee.html.twig';
        $currentYear = date('Y', time());
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $CRO = new CompteRenduOperation();
        $arrayLignesCompte = $this->getArrayLigneCompte();
        $arraysTypeMCY = $CRO->getMontantByCategoryAndYear($arrayLignesCompte);
        return $this->render($ratioCDView, array(
            'arraysTypeMCY' => $arraysTypeMCY,
            'comptes' => $comptes,
            'currentYear' => $currentYear
        ));
    }
    
    public function getArrayLigneCompte()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $repositoryLC = $em->getRepository(LigneCompte::class);
        $arrayLignesCompte = array();
        foreach($comptes as $compte){
            array_push($arrayLignesCompte, $repositoryLC->getAllLigneCompteByUser($compte));
        }
        return $arrayLignesCompte;
    }
}