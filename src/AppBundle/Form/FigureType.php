<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('name', TextType::class)
            ->add('content', TextareaType::class)
            ->add('rating', ChoiceType::class, array(
                "choices" => array(
                    'Novice' => 0,
                    'Débutant' => 1,
                    'Amateur' => 2,
                    'Confirmé' => 3,
                    'Expert' => 4,
                    "Pro" => 5

            )))
            ->add('groupFigure', ChoiceType::class, array(
                "choices" => array(
                    'Groupe 1' => 'Groupe 1',
                    'Groupe 2' => 'Groupe 2',
                    'Groupe 3' => 'Groupe 3'
                )));

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
