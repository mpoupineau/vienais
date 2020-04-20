<?php


namespace App\Form\Admin\News;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class,
                [
                    'required' => false,
                    'attr' => ['readonly' => true]
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
            ->add('title', TextType::class,
                [
                    'label' => 'Titre'
                ])
            ->add('text', TextareaType::class,
                [
                    'label' => 'Texte'
                ])
            ->add('createdAt', DateType::class,
                [
                    'label' => 'Date du publication',
                    'format' => 'dd/MM/yyyy',
                ])
            ->add('visible', CheckboxType::class,
                [
                    'required' => false
                ])
            ->add('homePage', CheckboxType::class,
                [
                    'label' => 'A la une',
                    'required' => false
                ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}