<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/22/2018
 * Time: 1:30 PM
 */

namespace Projet\BurgerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\BurgerBundle\Entity\Product;

class Products implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $noms= array('Burger 1','Burger 2','Burger 3','Burger 4','Burger 5');
        $desc= array('Sweet','Cool','Nice','Good','Bad');
        $prices= array('5$','2$','7$','3$','9$');
        $quantities= array('12','10','15','3','20');
        $dates= array('2018-03-21','2017-07-22','2018-07-22','2015-05-16','2018-06-14');
        $images= array('src/b1.jpg','src/b2.jpg','src/b3.jpg','src/b4.jpg','src/b5.jpg');
        $types= array('1','2','3','2','1');
        $state= array('1','1','1','2','1');

        $i=0;
        foreach ($noms as $nom)
        {
            $product=new Product();
            $product->setName($nom);
            $product->setDescription($desc[$i]);
            $product->setImageUrl($images[$i]);
            $product->setPrice($prices[$i]);
            $product->setQuantity($quantities[$i]);
            $date = date('Y-m-d', strtotime(str_replace('/','-',$dates[$i])));
            $product->setDateCreation($date);
            $product->setIdState($state[$i]);
            $product->setIdType($types[$i]);

            $manager->persist($product);
            $i=$i+1;
        }
        $manager->flush();
    }
}