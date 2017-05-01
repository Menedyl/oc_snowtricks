<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('url', TextType::class, array(
                'label' => 'URL :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control'),

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Url(array(
                        'message' => 'Ce champ doit contenir une URL valide.',
                        'checkDNS' => true,
                        'dnsMessage' => "Cette URL n'existe pas."
                    ))
                )
            ))
            ->add('alt', TextType::class, array(
                'label' => "Nom de l'image :",
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control'),

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Length(array(
                        'min' => 3,
                        'max' => 24,
                        'minMessage' => '3 caractères minimum.',
                        'maxMessage' => '24 caractères maximum.'
                    ))
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Image'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_image';
    }


}
