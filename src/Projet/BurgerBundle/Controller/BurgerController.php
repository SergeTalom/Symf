<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/19/2018
 * Time: 3:47 AM
 */

namespace Projet\BurgerBundle\Controller;


use Projet\BurgerBundle\Entity\Product;
use Projet\BurgerBundle\Entity\Test;
use Projet\BurgerBundle\ProjetBurgerBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BurgerController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /*$em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $t=$em->getRepository(Test::class)->findAll();
        $q=$t->
        $s=$rep->findAll();


        $list_product=$rep->findAll();*/
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
    }

    public function aindexAction()
    {
        /*$em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $t=$em->getRepository(Test::class)->findAll();
        $q=$t->
        $s=$rep->findAll();


        $list_product=$rep->findAll();*/
        return $this->render('ProjetBurgerBundle:Burger:aindex.html.twig');
    }

    public function catalogAction()
    {
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
    }

    public function nproductformAction()
    {
        return $this->render('ProjetBurgerBundle:Burger:nproductform.html.twig');
    }
}