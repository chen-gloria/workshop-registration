<?php

namespace App\Form\DataTransformer;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SelectToProgramTransformer implements DataTransformerInterface
{
    private $finderCallback;
    private $programRepository;

    public function __construct(ProgramRepository $programRepository, callable $finderCallback)
    {
        $this->programRepository = $programRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if (null == $value) {
            return '';
        }

        // Sanity Check
        if (!$value instanceof Program) {
            throw new \LogicException('The ProgramChoiceType can only be used with Program objects');
        }

        return $value->getName();
    }

    public function reverseTransform($value)
    {
        if (!$value){
            return;
        }

        $callback = $this->finderCallback;
        $program = $callback($this->programRepository, $value);

        if (!$program) {
            throw new TransformationFailedException(sprintf('No program found with email "%s"', $value));
        }

        return $program;
    }
}