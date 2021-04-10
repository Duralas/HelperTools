<?php

declare(strict_types=1);


namespace App\Form\Common;

use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\NumberType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\{
    Constraints\LessThanOrEqual,
    Constraints\PositiveOrZero
};

class LicenseExperienceType extends AbstractType
{
    public const MAX_EXPERIENCE = 200;

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'label' => 'license_experience_type.label',
                'attr' => [
                    'min' => 0,
                    'max' => static::MAX_EXPERIENCE,
                ],
                'constraints' => [
                    new PositiveOrZero(),
                    new LessThanOrEqual(['value' => static::MAX_EXPERIENCE])
                ],
                'html5' => true,
                'translation_domain' => 'form',
            ]
        );
    }

    public function getParent()
    {
        return NumberType::class;
    }
}
