<?php
namespace App\Form\Admin\Product;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 20:26
 */

use App\Entity\Capacity;
use App\Entity\Vintage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Bottle;

class BottleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class,
                [
                    'required' => false,
                    'attr' => ['readonly' => true]
                ])
            ->add('price', NumberType::class,
                [
                    'label' => 'Prix (en €)'
                ])
            ->add('promoPrice', NumberType::class,
                [
                    'required' => false,
                    'label' => 'Prix Promotion (en €)'
                ])
            ->add('vintage', EntityType::class,
                [
                    'label' => 'Type',
                    'class' => Vintage::class,
                    'choice_label' => function ($vintage) {
                        return $vintage->getYear() . " " . $vintage->getCuvee()->getName();
                    }
                ])
            ->add('capacity', EntityType::class,
                [
                    'label' => 'Contenant',
                    'class' => Capacity::class,
                    'choice_label' => 'name'
                ])
            ->add('visible', CheckboxType::class,
                [
                    'required' => false
                ])
            ->add('available', CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Disponible',
                ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bottle::class,
        ]);
    }
}