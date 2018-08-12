<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 8/12/2018
 * Time: 8:22 AM
 */

namespace Projet\BurgerBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AccountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array
    $options)
    {
        $builder
            ->add('login', TextType::class)
            ->add('password', PasswordType::class)
            ->add('user', new UserType())
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Projet\BurgerBundle\Entity\Account'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projet_burgerbundle_account';
    }
}