<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom de la figure :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Description de la figure :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('rating', ChoiceType::class, array(
                'choices' => array(
                    'Débutant' => 1,
                    'Amateur' => 2,
                    'Confirmé' => 3,
                    'Expert' => 4,
                    "Pro" => 5),
                'label' => 'Difficulté de la figure :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('groupFigure', ChoiceType::class, array(
                'choices' => array(
                    'Groupe 1' => 'Groupe 1',
                    'Groupe 2' => 'Groupe 2',
                    'Groupe 3' => 'Groupe 3'),
                'label' => 'Groupe de figure :',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('images', CollectionType::class, array(
                'by_reference' => false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Images :',
                'label_attr' => array('class' => 'control-label'),
                'entry_options' => array(
                    'attr' => array('class' => 'well'),
                    'label_attr' => array('hidden' => 'true')
                )
            ))
            ->add('videos', CollectionType::class, array(
                'by_reference' => false,
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Videos :',
                'label_attr' => array('class' => 'control-label'),
                'entry_options' => array(
                    'attr' => array('class' => 'well'),
                    'label_attr' => array('hidden' => true))
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
