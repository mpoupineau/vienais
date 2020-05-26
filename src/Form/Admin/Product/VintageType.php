<?php
namespace App\Form\Admin\Product;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 20:26
 */

use App\Entity\Cuvee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Vintage;

class VintageType extends AbstractType
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
            ->add('cuvee', EntityType::class,
                [
                    'label' => 'Type',
                    'class' => Cuvee::class,
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
            'data_class' => Vintage::class,
        ]);
    }
}