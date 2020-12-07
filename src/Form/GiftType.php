<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Gift;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'placeholder' => 'My gift',
                ],
                'help'  => 'Saisir un nom de cadeau',
            ])
            ->add('description', TextareaType::class)
            ->add('url', UrlType::class)
            ->add('category', EntityType::class, [
                'class'        => Category::class,
                'choice_label' => 'name',
                'label'        => 'Categorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gift::class,
        ]);
    }
}
