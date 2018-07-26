<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/22/2018
 * Time: 1:46 PM
 */

namespace Projet\BurgerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\BurgerBundle\Entity\Type;

class Types implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $noms= array('meat','vegetable','cheese');
        foreach ($noms as $type)
        {
            $list_type= new Type();
            $list_type->setType($type);

            $manager->persist($list_type);
        }

        $manager->flush();
    }
}