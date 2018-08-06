<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/19/2018
 * Time: 3:47 AM
 */

namespace Projet\BurgerBundle\Controller;

use Projet\BurgerBundle\Entity\Account;
use Projet\BurgerBundle\Entity\Content;
use Projet\BurgerBundle\Entity\Goodburger;
use Projet\BurgerBundle\Entity\Files;
use Projet\BurgerBundle\Entity\Product;
use Projet\BurgerBundle\Entity\State;
use Projet\BurgerBundle\Entity\Take;
use Projet\BurgerBundle\Entity\Type;
use Projet\BurgerBundle\Entity\User;
use Projet\BurgerBundle\Form\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

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
            if($prod->getState()->getIdState() != 2)
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
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $list_product=$rep->findAll();
        $product=array();
        $i=0;

        /** @var Product $prod */
        foreach ($list_product as $prod)
        {
                $product[] =$prod;
                $i +=1;
        }

        $mod=$i/3;
        return $this->render('ProjetBurgerBundle:Burger:catalog.html.twig', array('product' => $product, 'line' => $mod));
    }

    public function nproductformAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        if($id==0)
        {
            /**
             * @var Product $prod
             */
            $prod=new Product();
        }else{
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $prod
             */
            $prod=$rep->find($id);
        }

        /** @var Form $form */
        $form = $this->get("form.factory")->create(ProductType::class,$prod);

        if($request->isMethod("POST"))
        {

            $form->handleRequest($request);

            $prod->setDatecreation(new \DateTime());

            //save picture
            $file = new Files();

            if ($prod->getFile() != null) {
                $file->file = $prod->getFile();
                $prod->setImageUrl("img/".$prod->getFile()->getClientOriginalName());
                $file->add("", $prod->getImageUrl());
            }

            /**
             * @var Take $con
             */
            $con=new Take();
            $con->setIdGb($prod->getlocation());
            $con->setIdProduct($prod);

            //save information in database
            if($form->isValid()){
                $em->persist($con);
                $em->persist($prod);
                $em->flush();

                //set notification
                $datas["notification"] = "Save as successfull !";

                //create product
                $prod=new Product();
                $form = $this->get("form.factory")->create(ProductType::class,$prod);
            }


        }
        $datas["form"] =$form->createView();
        return $this->render('ProjetBurgerBundle:Burger:nproductform.html.twig',$datas);
    }

    public function pdescriptionAction(Product $prod,$id)
    {
        return $this->render('ProjetBurgerBundle:Burger:pdescription.html.twig', array('prod' => $prod));
    }

    public function ncityformAction(Request $request)
    {
        $gb=new Goodburger();
        $formbuilder= $this->createFormBuilder($gb);
        $formbuilder
            ->add('name', TextType::class)
            ->add('location', TextType::class)
            ->add('save', SubmitType::class);
        $form=$formbuilder->getForm();

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($gb);
                $em->flush();

                $datas["notification"] = "Save as successfull !";


            }
        }
        $datas["form"] =$form->createView();
        return $this->render('ProjetBurgerBundle:Burger:ncityform.html.twig',$datas);
    }

    public function dproductAction()
    {
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $list_product=$rep->findAll();

        return $this->render('ProjetBurgerBundle:Burger:dproduct.html.twig', array('product' => $list_product));
    }

    public function buaccountAction()
    {
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Account::class);
        $list_acc=$rep->findAll();

        return $this->render('ProjetBurgerBundle:Burger:buaccount.html.twig', array('account' => $list_acc));
    }

    public function vbuaccountAction(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $t=$_POST['bu'];
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Account::class);
            $reps=$em->getRepository(User::class);
            $repos=$em->getRepository(State::class);
            /**
             * @var User $u
             */
            $u=$reps->findOneBySurname($t);
            /**
             * @var Account $a
             */
            $a=$rep->findOneBy(array('idUser' => $u->getIdUser()));

            if ($a->getState()->getState()=='blocked')
            {
                /**
                 * @var State $s
                 */
                $s=$repos->findOneByState('ok');
                $a->setState($s);
                $em->persist($a);
                $datas["notification"] = "The account is ok it was blocked !!";
            }else{
                /**
                 * @var State $s
                 */
                $s=$repos->findOneByState('blocked');
                $a->setState($s);
                $em->persist($a);
                $datas["notification"] = "The account is now blocked !!";
            }

            $em->flush();

        }else{$datas["notification"] = "No thing to do !";}

        return $this->render('ProjetBurgerBundle:Burger:buaccount.html.twig',$datas);
    }

    public function vdproductAction(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $t=$_POST['dp'];
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $p
             */
            $p=$rep->findOneByName($t);
            if($p->getState()->getState()=='not available')
            {
                $rept=$em->getRepository(Take::class);
                $list_t=$rept->findByIdProduct($p->getIdProduct());
                if($list_t != null)
                {
                    /**
                     * @var Take $tak
                     */
                    foreach ($list_t as $tak)
                    {
                        $em->remove($tak);
                    }
                }
                $em->remove($p);
                $datas["notification"] = "Delete as successfull !";
            }else{
                $reps=$em->getRepository(State::class);
                /**
                 * @var State $s
                 */
                $s=$reps->findOneByState('not available');

                $p->setState($s);
                $em->persist($p);
                $datas["notification"] = "State changed as successfull !";
            }

            $em->flush();

        }else{$datas["notification"] = "Not Deleted !";}

        return $this->render('ProjetBurgerBundle:Burger:dproduct.html.twig',$datas);
    }

    public function eproductAction()
    {
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Product::class);
        $list_prod=$rep->findAll();

        return $this->render('ProjetBurgerBundle:Burger:eproduct.html.twig', array('product' => $list_prod));
    }

    public function veproductAction(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $t=$_POST['ep'];
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $prod
             */
            $prod=$rep->findOneByName($t);
            $url=$this->generateUrl('projet_burger_nproductform',array('id'=>$prod->getIdProduct()));
            return $this->redirect($url);
        }
        return $this->render('ProjetBurgerBundle:Burger:aindex.html.twig');

    }
}