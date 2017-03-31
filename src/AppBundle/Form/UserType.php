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
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'attr' => array('class' => 'form-control'),

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Length(array(
                        'min' => 5,
                        'max' => 20,
                        'minMessage' => '5 caractères minimum.',
                        'maxMessage' => '20 caractères maximum.'
                    ))
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Entrer votre adresse mail :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control'),

                'constraints' => array(
                    new Email(array(
                        'checkMX' => true,
                        'message' => "L'email n'est pas valide."
                    ))
                )
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
                ),

                'constraints' => array(
                    new Length(array(
                        'min' => 6,
                        'minMessage' => '6 caractères minimum.'
                    ))
                )
            ))
            ->add('avatar', AvatarType::class, array(
                'label' => 'Avatar :'
            ));
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
