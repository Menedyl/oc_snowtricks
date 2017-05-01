<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 07/04/2017
 * Time: 14:42
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    ))
                )
            ))
            ->add('mail', EmailType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Email(array(
                        'message' => 'Ce champ doit contenir une adresse mail valide.',
                        'checkMX' => true
                    ))
                )
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Length(array(
                        'min' => 10,
                        'minMessage' => '10 caractères minimum.'
                    ))
                )
            ));

    }

    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }

}
