<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 * Guillaume Vidal <guillaume.vidal@gmail.com>
 *
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)
        {
            $user = $event->getData();
            $form = $event->getForm();

            // Test pour vérifier si c'est un nouvel utilisateur
            if(!$user || null === $user->getId())
            {
                $form
                    ->add('username', TextType::class)
                    ->add('email', EmailType::class)
                    ->add('password', RepeatedType::class, array(
                        'type' => PasswordType::class,
                        'first_options'  => array('label' => 'Password'),
                        'second_options' => array('label' => 'Repeat Password')
                    ));
            } else {
                $form
                    ->add('fullname', TextType::class)
                    ->add('headshot', FileType::class);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
