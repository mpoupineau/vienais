<?php
namespace App\Form\Admin\Photo;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 20:26
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\PhotoTag;

class PhotoTagType extends AbstractType
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
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhotoTag::class,
        ]);
    }
}