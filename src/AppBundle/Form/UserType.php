<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Entrer votre pseudonyme :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Entrer votre adresse mail :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identique.',
                'first_name' => 'pass',
                'first_options' => array(
                    'label' => 'Entrer votre mot de passe :',
                    'label_attr' => array('class' => 'control-label'),
                    'attr' => array('class' => 'form-control')
                ),
                'second_name' => 'pass_checked',
                'second_options' => array(
                    'label' => 'Répéter votre mot de passe :',
                    'label_attr' => array('class' => 'control-label'),
                    'attr' => array('class' => 'form-control')
                )))
            ->add('avatar', AvatarType::class, array(
                'label' => 'Avatar :'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
