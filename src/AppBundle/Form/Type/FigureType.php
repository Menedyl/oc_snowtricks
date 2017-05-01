<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FigureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    )),
                    new Length(array(
                        'min' => 4,
                        'max' => 40,
                        'minMessage' => '4 caractères minimum.',
                        'maxMessage' => '40 caractères maximum.')),
                )
            ))
            ->add('content', TextareaType::class, array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ce champ ne peut être vide.'
                    ))
                )
            ))
            ->add('rating', ChoiceType::class, array(
                'choices' => array(
                    'Débutant' => 1,
                    'Amateur' => 2,
                    'Confirmé' => 3,
                    'Expert' => 4,
                    'Pro' => 5),
                'placeholder' => 'Choisissez une difficultée ...',

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Sélection requise.'
                    ))
                )
            ))
            ->add('groupFigure', EntityType::class, array(
                'class' => 'AppBundle\Entity\GroupFigure',
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un groupe ...',

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Sélection requise.'
                    ))
                )
            ))
            ->add('images', CollectionType::class, array(
                'by_reference' => false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,

                'entry_options' => array(
                    'attr' => array('class' => 'well image'),
                    'label_attr' => array('hidden' => true)),

                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Au moins 1 image doit être présente.'
                    )),
                )
            ))
            ->add('videos', CollectionType::class, array(
                'by_reference' => false,
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,

                'entry_options' => array(
                    'attr' => array('class' => 'well video'),
                    'label_attr' => array('hidden' => true)),

                'constraints' => array(
                    new NotBlank()
                )
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Figure'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_figure';
    }


}
