<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/19/2018
 * Time: 3:47 AM
 */

namespace Projet\BurgerBundle\Controller;


<<<<<<< HEAD
use Projet\BurgerBundle\Entity\Goodburger;
=======
use Projet\BurgerBundle\Entity\Files;
>>>>>>> 625acda6ec565b94e8d6f7168f3220b8418c6416
use Projet\BurgerBundle\Entity\Product;
use Projet\BurgerBundle\Entity\State;
use Projet\BurgerBundle\Entity\Type;
use Projet\BurgerBundle\Form\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
<<<<<<< HEAD
=======
use Symfony\Component\Form\Form;
>>>>>>> 625acda6ec565b94e8d6f7168f3220b8418c6416
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

    public function nproductformAction(Request $request)
    {
        $prod=new Product();

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

            //save information in database
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
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

                return $this->redirectToRoute('projet_burger_ahomepage');
            }
        }
        return $this->render('ProjetBurgerBundle:Burger:ncityform.html.twig',array('form' => $form->createView()));
    }
}