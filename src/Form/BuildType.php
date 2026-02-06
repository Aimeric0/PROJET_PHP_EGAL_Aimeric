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
use Doctrine\ORM\EntityRepository;

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
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('a')
                  ->where('a.type = :type')
                  ->setParameter('type', 'head')
                  ->orderBy('a.name', 'ASC');
            },
            ])
            ->add('chest', EntityType::class, [
    'class' => Armor::class,
    'choice_label' => 'name',
    'label' => 'Poitrine',
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('a')
                  ->where('a.type = :type')
                  ->setParameter('type', 'chest')
                  ->orderBy('a.name', 'ASC');
            },
            ])
            ->add('arms', EntityType::class, [
    'class' => Armor::class,
    'choice_label' => 'name',
    'label' => 'Bras',
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('a')
                  ->where('a.type = :type')
                  ->setParameter('type', 'arms')
                  ->orderBy('a.name', 'ASC');
            },
            ])
            ->add('waist', EntityType::class, [
    'class' => Armor::class,
    'choice_label' => 'name',
    'label' => 'Taille',
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('a')
                  ->where('a.type = :type')
                  ->setParameter('type', 'waist')
                  ->orderBy('a.name', 'ASC');
            },
            ])
            ->add('legs', EntityType::class, [
    'class' => Armor::class,
    'choice_label' => 'name',
    'label' => 'Jambes',
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('a')
                  ->where('a.type = :type')
                  ->setParameter('type', 'legs')
                  ->orderBy('a.name', 'ASC');
            },
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
