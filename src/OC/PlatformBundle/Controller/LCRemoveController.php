<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LCRemoveController extends Controller
{
    public function removeLcAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ligneCompte = $em->getRepository('OCPlatformBundle:LigneCompte')->find($id);
        
        $em->remove($ligneCompte);
        $em->flush();
        
        return $this->redirectToRoute('oc_platform_home');
    }
}