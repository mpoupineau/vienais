<?php


namespace App\Form\Client\Order;

use App\Entity\DeliveryAddress;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Jean'
                    ],
                ])
            ->add('lastname', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Dupont'
                    ]
                ])
            ->add('phone', TextType::class,
                [
                    'attr' => [
                        'placeholder' => '0607080910'
                    ],
                    'required' => false
                ])
            ->add('address', TextType::class,
                [
                    'attr' => [
                        'placeholder' => '3, rue des lavandières'
                    ],
                ])
            ->add('zipcode', TextType::class,
                [
                    'attr' => [
                        'placeholder' => '37140'
                    ],
                ])
            ->add('city', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Benais'
                    ],
                ])
            ->add('send', SubmitType::class,
                [
                    'label' => 'Valider',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryAddress::class,
        ]);
    }
}