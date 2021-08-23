<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Workshop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class WorkshopFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('program', ChoiceType::class, [
                'placeholder' => 'Choose a program',
                'choices' => [
                    'Body Attack' => 'bodyattack',
                    'Body Balance' => 'bodybalance',
                    'Body Combat' => 'bodycombat',
                    'Body Jam' => 'bodyjam',
                    'Body Pump' => 'bodypump',
                    'Body Step' => 'bodystep',
                    'RPM' => 'rpm',
                    'Sh\'bam' => 'shbam',
                    'The Trip' => 'the_trip'
                ],
            ])
            ->add('overview')
            ->add('location')
            ->add('startsAt')
            ->add('endsAt')
            ->add('capacity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}
