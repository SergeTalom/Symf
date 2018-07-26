<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 7/22/2018
 * Time: 1:59 PM
 */

namespace Projet\BurgerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\BurgerBundle\Entity\User;

class Users implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names= array('Talom Defo','Suffo Takam','Ngongang Patrick','Tene Ribot','Yandjeu Ariel');
        $surnames=array('Serge G','Danick O','','','');
        $address= array('Bambili','Belgique','Dschang','Dschang','Bambili');
        $phones= array('671534667','','699750911','691751608','699501078');
        $emails= array('talomdefoserge@gmail.com','sdanicktakam@gmail.com','ngongangpatrick@yahoo.fr','ceskoutseribot@gmail.com','arielnana@gmail.com');

        $i=0;
        foreach ($names as $name)
        {
            $list_user=new User();
            $list_user->setAddress($address[$i]);
            $list_user->setEmail($emails[$i]);
            $list_user->setName($name);
            $list_user->setSurname($surnames[$i]);
            $list_user->setPhone($phones[$i]);

            $manager->persist($list_user);
            $i=$i+1;
        }
    }
}