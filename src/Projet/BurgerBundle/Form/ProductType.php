<?php

namespace Projet\BurgerBundle\Form;

use Projet\BurgerBundle\Entity\Goodburger;
use Projet\BurgerBundle\Entity\State;
use Projet\BurgerBundle\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class)
            ->add('quantity', IntegerType::class)
           // ->add('imageUrl', TextType::class)
            ->add('file',FileType::class, ['required' =>"true"])
            ->add('State',EntityType::class,array(
                'class'=>State::class,
                'choice_label'=>'state',
                'required'=>true,
                'multiple'=>false,
                'empty_data'=>null
            ))
            ->add('Type',EntityType::class,array(
                'class'=>Type::class,
                'choice_label'=>'type',
                'required'=>true,
                'multiple'=>false,
                'empty_data'=>null
            ))
            ->add('location',EntityType::class,array(
                'class'=>Goodburger::class,
                'choice_label'=>'name',
                'required'=>true,
                'multiple'=>false,
                'empty_data'=>null
            ))
            ->add('save', SubmitType::class)
            ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Projet\BurgerBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projet_burgerbundle_product';
    }


}
