<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CRUDType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username' , null, [
                    'attr' => [
                        'placeholder' => 'Username',
                        'class' => 'form-control my-2'
                    ],
                ])
            /* ->add('password' , null, [
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'form-control my-2',
                    'disabled' => 'true'
                ],
            ]) */
            ->add('realname' , null, [
                'attr' => [
                    'placeholder' => 'Govie name',
                    'class' => 'form-control my-2'
                ],
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (image file, max size 8Mo)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, JPG, PNG, or WebP).',
                    ]),
                ],
            ])
            ->add('heroname' , null, [
                'attr' => [
                    'placeholder' => 'Hero name',
                    'class' => 'form-control my-2',
                    
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
