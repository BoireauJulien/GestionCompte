<?php
namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Category;
use OC\PlatformBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\PlatformBundle\Form\CategoryRemoveType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\PlatformBundle\Repository\CategoryRepository;
use OC\PlatformBundle\Entity\Compte;
use OC\PlatformBundle\Form\CompteType;
use OC\PlatformBundle\Form\CompteRemoveType;
use OC\PlatformBundle\Form\LigneDebitType;
use OC\PlatformBundle\Repository\CompteRepository;
use OC\PlatformBundle\Entity\LigneCompte;
use OC\PlatformBundle\Form\LigneCreditType;
use OC\PlatformBundle\Form\LigneCompteRemoveType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CompteController extends Controller
{
    public function indexAction(Request $request)
    {
        if($this->getUser() != null){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
            $repositoryLC = $em->getRepository(LigneCompte::class);
            $arraySolde = array();
         foreach($comptes as $compte){
                $solde = $repositoryLC->getSolde($compte);
                array_push($arraySolde, $solde);
            }
            $arrayLignesCompte= array();
            foreach($comptes as $compte){
                array_push($arrayLignesCompte, $repositoryLC->getAllLigneCompteFromCurrentMonth($compte));
            }
        
            //formulaire de suppression d'une ligne
            $formRemove = $this->get('form.factory')->create(LigneCompteRemoveType::class);
        
            if($request->isMethod('POST') && $formRemove->handleRequest($request)->isValid()){
                $id = intval($formRemove->get('id')->getData());
                $ligneToRemove = $em->getRepository(LigneCompte::class)->find($id);
                if($ligneToRemove === null)
                {
                    throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
                }
                $em->remove($ligneToRemove);
                $em->flush();
            
                return $this->redirectToRoute('oc_platform_home', array());
            }
        
            return $this->render('OCPlatformBundle:Gestion:index.html.twig', array(
                'arrayLignesCompte' => $arrayLignesCompte,
                'arrayCompte' => $comptes,
                'arraySolde' => $arraySolde,
                'formRemove' => $formRemove->createView()
            ));
        } else {
            return $this->render('OCPlatformBundle:Gestion:index.html.twig', array());
        }
    }
    
    public function ajoutOperationAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $ligneDebit = new LigneCompte();
        $ligneCredit = new LigneCompte();
        
        //Génération du formulaire de Débit
        $formDebit = $this->get('form.factory')->create(LigneDebitType::class, $ligneDebit);
        $formDebit->add('category', EntityType::class, array(
            'class' => 'OCPlatformBundle:Category',
            'choice_label' => 'catName',
            'multiple' => false,
            'query_builder' => function(CategoryRepository $repository) use($user){
            return $repository->getLikeQueryBuilder($user);
            }
        ));
        $formDebit->add('compte', EntityType::class, array(
            'class' => 'OCPlatformBundle:Compte',
            'choice_label' => 'accountName',
            'multiple' => false,
            'query_builder' => function(CompteRepository $repository) use($user){
            return $repository->getLikeQueryBuilder($user);
            }
        ));
        
        if($request->isMethod('POST') && $formDebit->handleRequest($request)->isValid() && $formDebit->isSubmitted()){
            $isDebit = $formDebit->get('isDebit')->getData();
            if($isDebit){
                $debit = $formDebit->get('montant')->getData();
                $ligneDebit->setMontant($debit);
            }
            $date = $formDebit->get('dateOp')->getData();
            $date = $date->format('Y-m-d');
            $monthYear = $this->getMonthYearFromDate($date);
            $year = $this->getYearFormDate($date);
            $ligneDebit->setMonthYear($monthYear);
            $ligneDebit->setYear($year);
            $ligneDebit->setIsDebit(true);
            $em->persist($ligneDebit);
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_ajout_operation',array());
        }
        
        //Génération du formulaire de débit
        $formCredit = $this->get('form.factory')->create(LigneCreditType::class, $ligneCredit);
        $formCredit->add('category', EntityType::class, array(
            'class' => 'OCPlatformBundle:Category',
            'choice_label' => 'catName',
            'multiple' => false,
            'query_builder' => function(CategoryRepository $repository) use($user){
            return $repository->getLikeQueryBuilder($user);
            }
            ));
        $formCredit->add('compte', EntityType::class, array(
            'class' => 'OCPlatformBundle:Compte',
            'choice_label' => 'accountName',
            'multiple' => false,
            'query_builder' => function(CompteRepository $repository) use($user){
            return $repository->getLikeQueryBuilder($user);
            }
            ));

        
        if($request->isMethod('POST') && $formCredit->handleRequest($request)->isValid() && $formCredit->isSubmitted()){
            $date = $formCredit->get('dateOp')->getData();
            $date = $date->format('Y-m-d');
            $monthYear = $this->getMonthYearFromDate($date);
            $year = $this->getYearFormDate($date);
            $ligneCredit->setMonthYear($monthYear);
            $ligneCredit->setYear($year);
            $em->persist($ligneCredit);
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_ajout_operation',array());
        }
        
        
        return $this->render('OCPlatformBundle:Gestion:ajoutOperation.html.twig', array(
            'formDebit' => $formDebit->createView(),
            'formCredit' => $formCredit->createView()
        ));
    }
    
    public function selectionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $categories = $em->getRepository(Category::class)->getCategoriesByUser($user);
        return $this->render('OCPlatformBundle:Gestion:selection.html.twig', array('categories' => $categories));
    }
    
    public function selectAction($catName, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $category = $em->getRepository(Category::class)->getCategoryByCatName($catName);
        $comptes = $em->getRepository(Compte::class)->getCompteByUser($user);
        $repositoryLC = $em->getRepository(LigneCompte::class);
        $arraysLigneCompte = array();
        foreach($comptes as $compte){
            array_push($arraysLigneCompte, $repositoryLC->getAllLigneCompteByCategory($compte, $category[0]));
        }
        
        return $this->render('@OCPlatform/Gestion/resultatSelection.html.twig', array(
            'arraysLC' => $arraysLigneCompte,
            'catName' => $catName,
            'comptes' => $comptes
        ));
    }
    
    public function compteRenduAction()
    {
        return $this->render('OCPlatformBundle:Gestion:compteRendu.html.twig', array());
    }
    
    public function gestionCompteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        
        //Gestion du formulaire d'ajout de catégorie
        $category = new Category;
        $formAddCat = $this->get('form.factory')->create(CategoryType::class, $category);
        
        if($request->isMethod('POST') && $formAddCat->handleRequest($request)->isValid()){
            $category->setUser($user);
            $em->persist($category);
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_gestion', array());
        }
        
        //Gestion du formulaire de suppression de catégorie:
        
        $formRemoveCat = $this->get('form.factory')->create(CategoryRemoveType::class);
        $formRemoveCat->add('categoryName', EntityType::class, array(
            'class' => 'OCPlatformBundle:Category',
            'choice_label' => 'catName',
            'multiple' => true,
            'query_builder' => function(CategoryRepository $repository) use($user){
                return $repository->getLikeQueryBuilder($user);
            }
        ));
        if($formRemoveCat->handleRequest($request)->isValid() && $request->isMethod('POST')){
            $entityCats = $formRemoveCat->get('categoryName')->getData();
            foreach($entityCats as $entityCat){
                $em->remove($entityCat);
            }
            
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_gestion', array());
        }
        
        // Gestion du formulaire d'ajout de Compte Bancaire
        $account = new Compte();
        
        $formAddAccount = $this->get('form.factory')->create(CompteType::class, $account);
        
        if($request->isMethod('POST') && $formAddAccount->handleRequest($request)->isValid()){
            $account->setUser($user);
            $em->persist($account);
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_gestion', array());
        }
        
        //Gestion du formulaire de suppression de compte bancaire
        $formSupAccount = $this->get('form.factory')->create(CompteRemoveType::class);
        $formSupAccount->add('accounts', EntityType::class, array(
            'class' => 'OCPlatformBundle:Compte',
            'choice_label' => 'accountName',
            'multiple' => true,
            'query_builder' => function(CompteRepository $repository) use($user){
                return $repository->getLikeQueryBuilder($user);
            }
        ));
        
        if($request->isMethod('POST') && $formSupAccount->handleRequest($request)->isValid()){
            $entityAccounts = $formSupAccount->get('accounts')->getData();
            foreach($entityAccounts as $account){
                $em->remove($account);
            }
            $em->flush();
            
            return $this->redirectToRoute('oc_platform_gestion', array());
        }
        
        return $this->render('OCPlatformBundle:Gestion:gestionCompte.html.twig', array(
            'formAddCat' => $formAddCat->createView(),
            'formRemoveCat' => $formRemoveCat->createView(),
            'formAddAccount' => $formAddAccount->createView(),
            'formSupAccount' => $formSupAccount->createView()
        ));
    }
    
    public function profileAction()
    {
        return $this->render('@OCPlatform/Gestion/User/profileUser.html.twig', array());
    }
    
    public function getMonthYearFromDate($date)
    {
        $arrayDate = explode('-', $date);
        $month = date("n", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        $year = date("Y", mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
        $monthYear = $month.$year."";
        return intVal($monthYear);
    }
    
    public function getYearFormDate($date)
    {
        $arrayDate = explode('-', $date);
        $year = date('Y', mktime(0,0,0,$arrayDate[1], $arrayDate[2], $arrayDate[0]));
        return intVal($year);
    }
}