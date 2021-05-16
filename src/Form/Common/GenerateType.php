<?php

declare(strict_types=1);

namespace App\Form\Common;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateType extends SubmitType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Générer',
        ]);
    }

    public function getParent(): string
    {
        return SubmitType::class;
    }
}
