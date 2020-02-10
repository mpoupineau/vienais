<?php
namespace App\Form\Admin\Product;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 20:26
 */

use App\Entity\Cuvee;
use App\Entity\Capacity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('year', IntegerType::class,
                [
                    'label' => 'Année'
                ])
            ->add('price', NumberType::class,
                [
                    'label' => 'Prix (en €)'
                ])
            ->add('cuvee', EntityType::class,
                [
                    'label' => 'Type',
                    'class' => Cuvee::class,
                    'choice_label' => 'name'
                ])
            ->add('capacity', EntityType::class,
                [
                    'label' => 'Contenant',
                    'class' => Capacity::class,
                    'choice_label' => 'name'
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Description'
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
            ->add('priority', IntegerType::class,
                [
                    'label' => 'Priorité'
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