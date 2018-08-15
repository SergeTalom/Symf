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
use Projet\BurgerBundle\Entity\Checkout;
use Projet\BurgerBundle\Entity\Content;
use Projet\BurgerBundle\Entity\Goodburger;
use Projet\BurgerBundle\Entity\Files;
use Projet\BurgerBundle\Entity\Product;
use Projet\BurgerBundle\Entity\State;
use Projet\BurgerBundle\Entity\Take;
use Projet\BurgerBundle\Entity\Type;
use Projet\BurgerBundle\Entity\User;
use Projet\BurgerBundle\Form\AccountType;
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
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Options;
use Dompdf\Dompdf;

class BurgerController extends Controller
{
    public function initializeAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $repu=$em->getRepository(User::class);
        $user=$repu->find($id);

        $request->getSession()->set('user',$user);

        $conte=array();
        $request->getSession()->set('acontent',$conte);

        $cart=new Cart();
        $cart->setIdUser($user);
        $em->persist($cart);
        $em->flush();

        $request->getSession()->set('cart',$cart->getIdCart());
        $date=new \DateTime('now');
        $request->getSession()->set('date', $date);

        return $this->redirectToRoute('projet_burger_homepage');
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id,Request $request)
    {
        $cart=$request->getSession()->get('cart');
        $em=$this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $repu=$em->getRepository(User::class);
        $user=$repu->find($id);

        $request->getSession()->set('user',$user);

        $rep=$em->getRepository(Product::class);
        $list_product=$rep->findAll();
        $product=array();
        $i=0;

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
            $idc=$request->getSession()->get('cart');

            $repca=$em->getRepository(Cart::class);
            /**
             * @var Cart $cart
             */
            $ca=$repca->find($idc);

            $repc=$em->getRepository(Content::class);
            /**
             * @var Content $con
             */
            $con=$repc->findOneBy(array('idProduct'=>$prod->getIdProduct(),'idCart'=>$ca->getIdCart()));
            if($qted>0)
            {
                if($prod->getQuantity()>=$qted && $con==null)
                {
                    $con=new Content();
                    $con->setIdProduct($prod);
                    $con->setQuantity($qted);
                    $con->setIdCart($ca);

                    $acontent=$request->getSession()->get('acontent');
                    $acontent[] = $con;
                    $request->getSession()->set('acontent',$acontent);

                    $em->persist($con);
                    $datas["notification"] = "Save as successfull !";
                }else{
                    if ($prod->getQuantity()<$qted)
                    {
                        $datas["notification"] = "The quantity available is !".$prod->getQuantity()." which is lower than ".$qted;
                    }else{
                        $datas["notification"] = "The product is already in your cart !";
                    }
                }
                $em->flush();
            }else{
                $datas["notification"]="Please enter a valid quantity";
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
            if($user != null && $user->getState()->getIdState()==4)
            {
                $cart=$this->get('session')->get('cart');
                $repc=$em->getRepository(Cart::class);
                /**
                 * @var Cart $ca
                 */
                $ca=$repc->find($cart);
                $ca->setIdUser($user->getIdUser());
                $em->persist($ca);
                $em->flush();

                $request->getSession()->set('account',$user);
                return $this->redirectToRoute('projet_burger_homepage',array('id'=>$user->getIdUser()->getIdUser()));
            }
            return $this->redirectToRoute('projet_burger_homepage');
        }
        return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
    }

    public function nuserAction(Request $request)
    {
        return $this->render('ProjetBurgerBundle:Burger:nuserform.html.twig');
    }

    public function cdisplayAction(Request $request)
    {
        $list_cont=$request->getSession()->get('acontent');
        $list=array();
        /**
         * @var Content $con
         */
        foreach ($list_cont as $con)
        {
            $list[]=$con;
        }

        return $this->render('ProjetBurgerBundle:Burger:cdisplay.html.twig',array('content'=>$list));
    }

    public function qmodifyAction($id,Request $request)
    {
        if($request->isMethod('POST'))
        {
            $qty=$_POST['qty'];
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $prod
             */
            $prod=$rep->find($id);
            if ($qty>0) {
                if ($prod->getQuantity() >= $qty) {

                    $cart = $request->getSession()->get('cart');
                    $repco = $em->getRepository(Content::class);
                    $repc = $em->getRepository(Cart::class);
                    /**
                     * @var Cart $c
                     */
                    $c = $repc->find($cart);
                    $list = array();
                    $acontent = $request->getSession()->get('acontent');
                    /**
                     * @var Content $con
                     */
                    foreach ($acontent as $con) {
                        if ($con->getIdCart()->getIdCart() == $c->getIdCart() && $con->getIdProduct()->getIdProduct() == $prod->getIdProduct()) {
                            /**
                             * @var Content $co
                             */
                            $co = $repco->findOneBy(array('idProduct' => $prod, 'idCart' => $cart));
                            $co->setQuantity($qty);
                            $em->persist($co);
                            $con->setQuantity($qty);
                        }
                        $list[] = $con;
                    }
                    $request->getSession()->set('acontent', $list);
                    $em->flush();

                    $datas["notification"] = "Modify as successfull !";
                } else {
                    $datas["notification"] = "The quantity available is !" . $prod->getQuantity() . " which is lower than " . $qty;
                }
            }else{
                $datas["notification"]="Please enter a valid quantity";
            }
            return $this->redirectToRoute('projet_burger_cdisplay');
        }
    }

    public function vnuserAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $name=$_POST['name'];
            $surname=$_POST['surname'];
            $email=$_POST['email'];
            $address=$_POST['address'];
            $number=$_POST['number'];
            $login=$_POST['login'];
            $pass=$_POST['password'];

            $user=new User();
            $user->setName($name);
            $user->setPhone($number);
            $user->setSurname($surname);
            $user->setAddress($address);
            $user->setEmail($email);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $acc=new Account();
            $acc->setLogin($login);
            $acc->setPassword($pass);
            $acc->setIdUser($user);

            $rep=$em->getRepository(State::class);
            /**
             * @var State $s
             */
            $s=$rep->findOneBy(array('state'=>'ok'));

            $acc->setState($s);
            $em->persist($acc);
            $em->flush();

            return $this->redirectToRoute('projet_burger_homepage',array('id'=>$user->getIdUser()));
        }

        return $this->render('ProjetBurgerBundle:Burger:index.html.twig');
    }

    public function cpasswordAction()
    {
        return $this->render('ProjetBurgerBundle:Burger:cpassword.html.twig');
    }

    public function vcpasswordAction(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $ap=$_POST['ppassword'];
            $pass=$_POST['password'];
            /**
             * @var User $user
             */
            $user=$request->getSession()->get('user');

            $em=$this->getDoctrine()->getManager();
            $repa=$em->getRepository(Account::class);

            /**
             * @var Account $acc
             */
            $acc=$request->getSession()->get('account');

            if($acc->getPassword()==$ap)
            {
                $acc->setPassword($pass);
                $request->getSession()->set('account',$acc);

                /**
                 * @var Account $a
                 */
                $a=$repa->find($acc->getLogin());
                $a->setPassword($pass);
                $em->flush();
                $datas["notification"]="Save as successful";
            }else{
                $datas["notification"]="The old password is wrong";
            }
            return $this->render('ProjetBurgerBundle:Burger:cpassword.html.twig',$datas);
        }
        return $this->render('ProjetBurgerBundle:Burger:cpassword.html.twig');
    }

    public function checkoutAction(Request $request)
    {
        $list_cont=$request->getSession()->get('acontent');
        $list=array();
        /**
         * @var Content $con
         */
        foreach ($list_cont as $con)
        {
            $list[]=$con;
        }

        return $this->render('ProjetBurgerBundle:Burger:checkdisplay.html.twig',array('content'=>$list));
    }

    public function test(User $user,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $cart=new Cart();
        $cart->setIdUser($user);
        $request->getSession()->set('cart',$cart->getIdCart());
        $em->persist($cart);
        $em->flush();
    }

    public function vcheckAction(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $list_cont=$request->getSession()->get('acontent');
            $listt=array();
            /**
             * @var User $us
             */
            $us=$request->getSession()->get('user');
            $cart=$request->getSession()->get('cart');
            $list=array();
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            $repu=$em->getRepository(User::class);
            $repc=$em->getRepository(Content::class);
            $repca=$em->getRepository(Cart::class);
            /**
             * @var Cart $ca
             */
            $ca=$repca->find($cart);
            /**
             * @var User $user
             */
            $user=$repu->find($us->getIdUser());
            /**
             * @var Content $con
             */
            foreach ($list_cont as $con)
            {
                $listt[]=$con;
                $c=$repc->findOneBy(array('idProduct'=>$con->getIdProduct(),'idCart'=>$con->getIdCart()));
                /**
                 * @var Product $prod
                 */
                $prod=$rep->find($c->getIdProduct()->getIdProduct());
                $nq=$prod->getQuantity()-$c->getQuantity();
                $prod->setQuantity($nq);
                if($nq==0)
                {
                    $reps=$em->getRepository(State::class);
                    /**
                     * @var State $state
                     */
                    $state=$reps->findOneBy(array('state'=>'not available'));
                    $prod->setState($state);
                }

                $em->persist($prod);
                $em->flush();
            }
            $total=$_POST['total'];

            $ch=new Checkout();
            $ch->setIdUser($user);
            $ch->setIdCart($ca->getIdCart());
            $ch->setTotalPrice($total);
            $ch->setDateOut(new \DateTime());
            $em->persist($ch);
            $em->flush();
            $request->getSession()->set('user',$user);


            $request->getSession()->set('acontent',$list);
            $this->test($user,$request);
            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $dompdf = new Dompdf($options);
            $html = $this->renderView('ProjetBurgerBundle:Burger:receipt.html.twig',array('content'=>$listt));
            $dompdf->loadHtml($html);
            $dompdf->render();


            return new Response($dompdf->stream());
        }
        $datas["notification"]="Checkout Impossible";
        return $this->render('ProjetBurgerBundle:Burger:try.html.twig');
    }

    public function cremoveAction($id,$cart,Request $request)
    {
        if($request->isMethod('POST'))
        {
            $em=$this->getDoctrine()->getManager();
            $rep=$em->getRepository(Product::class);
            /**
             * @var Product $prod
             */
            $prod=$rep->find($id);

            $repco = $em->getRepository(Content::class);
            $repc = $em->getRepository(Cart::class);
            /**
             * @var Cart $c
             */
            $c = $repc->find($cart);
            $list = array();
            $acontent = $request->getSession()->get('acontent');

            /**
             * @var Content $con
             */
            foreach ($acontent as $con) {
                if ($con->getIdCart()->getIdCart() == $c->getIdCart() && $con->getIdProduct()->getIdProduct() == $prod->getIdProduct()) {
                    /**
                     * @var Content $co
                     */
                    $co = $repco->findOneBy(array('idProduct' => $prod, 'idCart' => $cart));
                    $em->remove($co);
                }else{
                    $list[] = $con;
                }
            }
            $request->getSession()->set('acontent', $list);
            $em->flush();

            $datas["notification"] = "Remove as successfull !";

            return $this->redirectToRoute('projet_burger_cdisplay');
        }
    }

}