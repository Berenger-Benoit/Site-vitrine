<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'trim' => true,
            ])
            ->add('description', TextType::class, [
                'required'   => false,
            ])
            ->add('origin')
            ->add('price', MoneyType::class, [
                'invalid_message' => "Cette valeur doit être de type numérique",
                'trim' => true,

            ])
            ->add('weight',NumberType::class, [
                'invalid_message' => "Cette valeur doit être de type numérique",
                'trim' => true,

            ])
            ->add('type',ChoiceType::class,[
                'choices'  => [
                    'Kg' => 'kg',
                    'Piece' => 'pièce(s)',
                ],
                'multiple' => true,
            ])
            ->add('category')
            ->add('imageFile', FileType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

  
}
