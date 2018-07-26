<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/22/2018
 * Time: 1:49 PM
 */

namespace Projet\BurgerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\BurgerBundle\Entity\State;

class States implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $states= array('available','not available');

        foreach ($states as $state)
        {
            $list_state= new State();
            $list_state->setState($state);

            $manager->persist($list_state);
        }

        $manager->flush();
    }
}