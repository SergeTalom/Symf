<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/19/2018
 * Time: 3:47 AM
 */

namespace Projet\BurgerBundle\Controller;

use Projet\BurgerBundle\Entity\Account;
use Projet\BurgerBundle\Entity\Admin;
use Projet\BurgerBundle\Entity\Cart;
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
    public function indexAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        /**
         * @var User $user
         */
        $user=new User();
        if($id==0)
        {
            $user->setIdUser($id);
        }else{
           $repu=$em->getRepository(User::class);
           $user=$repu->find($id);
        }

        $this->get('session')->set('user',$user);
        $rep=$em->getRepository(Product::class);
        $list_product=$rep->findAll();
        $product=array();
        $i=0;
        if(!$this->get('session')->has('acontent'))
        {
            $conte=array();
            $this->get('session')->set('acontent',$conte);

        }
        if(!$this->get('session')->has('cart'))
        {
            /**
             * @var Cart $cart
             */
            $cart=new Cart();
            $cart->setIdUser($user);
            $em->persist($cart);
            $this->get('session')->set('cart',$cart);
            $tab=array();
            $this->get('session')->set('table',$tab);
        }else{
            /**
             * @var Cart $cart
             */
            $cart=$this->get('session')->get('cart');
        }

        /** @var Product $prod */
        foreach ($list_product as $prod)
        {
            if($prod->getState()->getIdState() != 2)
            {
                $product[] =$prod;
                $i +=1;

            }
        }

        $mod=$i/3;
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig', array('product' => $product, 'line' => $mod,'user'=>$user,'cart'=>$cart));
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

            $reps=$em->getRepository(Take::class);
            /**
             * @var Take $con
             */
            $con=$reps->findOneBy(array('idGb'=>$prod->getlocation(),'idProduct'=>$prod));

            //save information in database
            if($form->isValid()){
                if($con==null)
                {
                    $con->setIdGb($prod->getlocation());
                    $con->setIdProduct($prod);
                    $em->persist($con);
                }
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

    public function valideAction(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $id= $request->get('id');
            $qted= $request->get('qted');
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $prod
             */
            $prod=$rep->find($id);
            /**
             * @var Cart $cart
             */
            $cart=$this->get('session')->get('cart');

            $repc=$em->getRepository(Content::class);
            /**
             * @var Content $con
             */
            $con=$repc->findOneBy(array('idProduct'=>$prod->getIdProduct(),'idCart'=>$cart->getIdCart()));
            if($prod->getQuantity()>=$qted && $con==null)
            {
                $con=new Content();
                $con->setIdProduct($prod->getIdProduct());
                $con->setQuantity($qted);
                $con->setIdCart($cart);

                $acontent=$this->get('session')->get('acontent');
                $acontent[] = $con;
                $this->get('session')->set('acontent',$acontent);

                $em->persist($con);
                $em->flush();
                $datas["notification"] = "Save as successfull !";

            }else{
                if ($prod->getQuantity()<$qted)
                {
                    $datas["notification"] = "The quantity available is !".$prod->getQuantity()." which is lower than ".$qted;
                }else{
                    $datas["notification"] = "The product is already in your cart !";
                }
            }
            return $this->render('ProjetBurgerBundle:Burger:try.html.twig',$datas);
        }
        return $this->render('ProjetBurgerBundle:Burger:try.html.twig');
    }

    public function adminconAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $log=$_POST['useradmin'];
            $pass=$_POST['adminpass'];

            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Admin::class);

            /**
             * @var Admin $admin
             */
            $admin=$rep->findOneBy(array('login'=>$log,'password'=>$pass));
            if($admin != null)
            {
                return $this->render('ProjetBurgerBundle:Burger:aindex.html.twig');
            }
            return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
        }
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
    }

    public function userconAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $log=$_POST['name'];
            $pass=$_POST['password'];

            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Account::class);

            /**
             * @var Account $user
             */
            $user=$rep->findOneBy(array('login'=>$log,'password'=>$pass));
            if($user != null)
            {
                /**
                 * @var Cart $cart
                 */
                $cart=$this->get('session')->get('cart');
                $cart->setIdUser($user);
                $em->persist($cart);
                $em->flush();
                return $this->redirectToRoute('projet_burger_homepage',array('id'=>$user->getIdUser()->getIdUser()));
            }
            return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
        }
    }

    public function nuserAction()
    {
        return $this->render('ProjetBurgerBundle:Burger:aindex.html.twig');
    }
}