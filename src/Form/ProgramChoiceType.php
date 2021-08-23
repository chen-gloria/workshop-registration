<?php

namespace App\Form;

use App\Repository\ProgramRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\SelectToProgramTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ProgramChoiceType extends AbstractType
{
    private $programRepository;
    private $router;

    public function __construct(ProgramRepository $programRepository, RouterInterface $router)
    {
        $this->programRepository = $programRepository;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new SelectToProgramTransformer(
            $this->programRepository,
            $options['finder_callback']
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Hmm, program not found!',
            'finder_callback' => function(ProgramRepository $programRepository, string $name) {
                return $programRepository->findOneBy(['name' => $name]);
            }
        ]);
    }
}