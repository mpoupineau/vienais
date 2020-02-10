<?php
namespace App\Form\Admin\Photo;


use App\Entity\Photo;
use App\Entity\PhotoTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class,
                [
                    'required' => false,
                    'attr' => ['readonly' => true]
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
            ->add('photoTags', EntityType::class,
                [
                'label'     => 'Etiquette',
                'class'     => PhotoTag::class,
                'choice_label' => 'name',
                'expanded'  => true,
                'multiple'  => true,
                ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}