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
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $list_product=$rep->findAll();
        $product=array();
        $i=0;

        /** @var Product $prod */
        foreach ($list_product as $prod)
        {
            if($prod->getIdState()->getIdState() != 2)
            {
                $product[] =$prod; //plutôt
                $i +=1;

            }
        }

        $mod=$i/3;
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig', array('product' => $product, 'line' => $mod));
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

    public function pdescriptionAction(Product $prod,$id)
    {
        return $this->render('ProjetBurgerBundle:Burger:pdescription.html.twig', array('prod' => $prod));
    }
}