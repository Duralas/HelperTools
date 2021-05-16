<?php

declare(strict_types=1);

namespace App\Form\Common;

use App\Form\Common\Typed\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdditionalRewardType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Récompense additionnelle de bon RP',
            'required' => false,
        ]);
    }

    public function getParent(): string
    {
        return StringType::class;
    }
}
