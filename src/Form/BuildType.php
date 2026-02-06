<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Weapon;
use App\Entity\Armor;
use App\Entity\Charm;
use App\Entity\BuildDecoration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du Build',
            ])
            ->add('weapon', EntityType::class, [
                'class' => Weapon::class,
                'choice_label' => 'name',
                'label' => 'Arme',
            ])
            ->add('head', EntityType::class, [
                'class' => Armor::class,
                'choice_label' => 'name',
                'label' => 'Tête',
            ])
            ->add('chest', EntityType::class, [
                'class' => Armor::class,
                'choice_label' => 'name',
                'label' => 'Poitrine',
            ])
            ->add('arms', EntityType::class, [
                'class' => Armor::class,
                'choice_label' => 'name',
                'label' => 'Bras',
            ])
            ->add('waist', EntityType::class, [
                'class' => Armor::class,
                'choice_label' => 'name',
                'label' => 'Taille',
            ])
            ->add('legs', EntityType::class, [
                'class' => Armor::class,
                'choice_label' => 'name',
                'label' => 'Jambes',
            ])
            ->add('charm', EntityType::class, [
                'class' => Charm::class,
                'choice_label' => 'name',
                'label' => 'Charme',
                'required' => false,
            ])
            ->add('buildDecorations', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => BuildDecoration::class,
                    'choice_label' => 'name',
                    'label' => false,
                ],
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Décorations',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Build::class,
        ]);
    }
}
