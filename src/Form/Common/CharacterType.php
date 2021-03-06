<?php

declare(strict_types=1);

namespace App\Form\Common;

use App\Form\Common\Typed\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Nom',
        ]);
    }

    public function getParent(): string
    {
        return StringType::class;
    }
}
