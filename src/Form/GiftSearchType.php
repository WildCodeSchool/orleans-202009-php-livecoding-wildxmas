<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\GiftSearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiftSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('input', SearchType::class, [
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class'         => Category::class,
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->where('c.universe = :universe')
                        ->setParameter('universe', $options['universe'])
                        ->orderBy('c.name', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => GiftSearch::class,
            'csrf_protection' => false,
            'universe'        => null,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
