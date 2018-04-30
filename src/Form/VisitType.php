<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Form;

use App\Entity\Visit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class VisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'visit.form.name',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'visit.form.location',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('sqft', IntegerType::class, [
                'label' => 'visit.form.sqft',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'visit.form.price',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('cover', FileType::class, [
                'label' => 'visit.form.cover',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
