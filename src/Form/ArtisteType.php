<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Live;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('Spotify')
            ->add('Deezer')
            ->add('annee')
            ->add('origine')
            ->add('nomSpectacleSoiree')
            ->add('dates')
            ->add('lang_code', TextType::class)
            ->add('isReceivingQuest')
            ->add('is_ilomember')
            ->add('label_sp')
            ->add('label_en')
            ->add('ONU_code')
            ->add('events')
            ->add('notifications')
            ->add('edition')
            ->add('ajouter', SubmitType::class)
            ->get('origine')
            ->resetModelTransformers()
            ->addViewTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ',$tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ));
        $builder
            ->get('lang_code')
            ->resetModelTransformers()
            ->addViewTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ',$tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
