<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 8/3/2018
 * Time: 6:08 AM
 */

namespace Projet\BurgerBundle\Form;


use Projet\BurgerBundle\Entity\State;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => State::class
        ));
    }
}