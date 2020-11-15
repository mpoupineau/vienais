<?php


namespace App\Form\Client\Contact;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
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
            ->add('email', EmailType::class,
                [
                    'attr' => [
                        'placeholder' => 'exemple@mail.com'
                    ],
                ])
            ->add('comment', TextareaType::class,
                [
                    'attr' => [
                        'placeholder' => 'message'
                    ],
                ])
            ->add('location', HiddenType::class,
                [
                    'required' => false,
                    'mapped' => false,
                ])
            ->add('send', SubmitType::class,
                [
                    'label' => 'Envoyer',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}