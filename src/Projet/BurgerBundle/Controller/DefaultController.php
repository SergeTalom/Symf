<?php

namespace Projet\BurgerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjetBurgerBundle:Default:index.html.twig');
    }
}
