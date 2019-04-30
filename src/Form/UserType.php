<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'conundrum.user.form.email.label'])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'first_options'  => [
                    'label' => 'conundrum.user.form.password.label',
                    'attr' => ['placeholder' => 'conundrum.user.form.password.placeholder'],
                    'constraints' => [
                        new NotBlank(['message' => 'conundrum.user.form.password.error.not_blank']),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'conundrum.user.form.password.error.length.min',
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'attr' => ['placeholder' => 'conundrum.user.form.password_repeated.placeholder'],
                    'label' => false,
                ],
                'invalid_message' => 'conundrum.user.form.password.error.passwords_not_equal',
            ])
            ->add('submit', SubmitType::class, ['label' => 'conundrum.user.form.submit.label'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'conundrum',
        ]);
    }
}
