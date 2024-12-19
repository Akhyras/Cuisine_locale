<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recipeName', TextType::class,[
                'label'=> 'Nom de la recette'
            ])
            ->add('recipeLatitude', NumberType::class, [
                'label'=> 'Latitude'
            ])
            ->add('recipeLongitude', NumberType::class,[
                'label'=> 'longitude'
            ])
            ->add('recipeDescription', TextareaType::class, [
                'label' => 'Description de la recette', // Optionnel : texte affiché pour le champ
                'attr' => [
                    'rows' => 5, // Nombre de lignes du textarea
                    'cols' => 50, // Largeur du textarea (optionnel)
                    'placeholder' => 'Décrivez la recette ici...', // Texte d'indication dans le champ
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
