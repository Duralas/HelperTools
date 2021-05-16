<?php

declare(strict_types=1);

namespace App\Form\Common;

use App\Form\Common\Typed\IntType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CraftingExperienceType extends AbstractType
{
    public const EXPERIENCE_BY_RP = 5;
    public const MAX_EXPERIENCE = 200;
    public const MIN_REQUIREMENT_APPRENTICE = 41;
    public const MIN_REQUIREMENT_JOURNEYMAN = 81;
    public const MIN_REQUIREMENT_EXPERT = 121;
    public const MIN_REQUIREMENT_MASTER = 161;
    public const MIN_REQUIREMENT_ABSOLUTE_MASTER = 200;

    public const LICENSE_RANK_APPRENTICE = 'apprentice';
    public const LICENSE_RANK_JOURNEYMAN = 'journeyman';
    public const LICENSE_RANK_EXPERT = 'expert';
    public const LICENSE_RANK_MASTER = 'master';
    public const LICENSE_RANK_ABSOLUTE_MASTER = 'absolute_master';

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'attr' => [
                    'min' => 0,
                    'max' => static::MAX_EXPERIENCE,
                ],
                'empty_data' => null,
                'label' => 'Points métier',
                'required' => false,
            ]
        );
    }

    public function getParent(): string
    {
        return IntType::class;
    }
}
