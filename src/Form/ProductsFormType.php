<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Nom'
                ])
            ->add('description')
            ->add('price', options:[
                'label' => 'Prix'
                ])
            ->add('stock', options:[
                'label' => 'Unités en stock'
                ])
            
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                // permet de créer une liste déroulante des catégories:
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'group_by' => 'parent.name',
                'query_builder' => function(CategoriesRepository $cr)
                { 
                    // désormais pour remplir la liste déroulante, 
                    // il va récupérer les catégories "enfant" selon le parent par ordre alpha
                    // et les catégories Mode et informatique ne sont pas sélectionables
                    return $cr->createQueryBuilder('c')
                    ->where('c.parent IS NOT NULL')
                    ->orderBy('c.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
