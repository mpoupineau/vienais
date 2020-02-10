<?php
namespace App\Form\Admin\Product;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 20:26
 */

use App\Entity\WineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
use App\Entity\Cuvee;

class CuveeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class,
                [
                    'required' => false,
                    'attr' => ['readonly' => true]
                ])
            ->add('name', TextType::class,
                [
                    'label' => 'Nom'
                ])
            ->add('wineType', EntityType::class,
                [
                    'label' => 'Type',
                    'class' => WineType::class,
                    'choice_label' => 'name'
                ])
            ->add('variety', TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Cépage'
                ])
            ->add('vinification', TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Vinification'
                ])
            ->add('tasting', TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Dégustation'
                ])
            ->add('accord', TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Accord'
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Description'
                ])
            ->add('visible', CheckboxType::class,
                [
                    'required' => false
                ])
            ->add('image_path', HiddenType::class,
                [
                    'required' => false,
                    'attr' => ['readonly' => true]
                ])
            ->add('image_file', FileType::class,
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
            'data_class' => Cuvee::class,
        ]);
    }
}