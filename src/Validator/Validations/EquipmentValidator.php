<?php

declare(strict_types=1);

namespace App\Validator\Validations;

use App\{
    Entity\Equipment,
    Validator\Constraints\Equipment as EquipmentConstraint
};
use Symfony\Component\Validator\{
    Constraint,
    ConstraintValidator,
    Exception\UnexpectedTypeException,
    Exception\UnexpectedValueException
};
use Symfony\Contracts\Translation\TranslatorInterface;

final class EquipmentValidator extends ConstraintValidator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof EquipmentConstraint === false) {
            throw new UnexpectedTypeException($constraint, EquipmentConstraint::class);
        }

        if ($constraint->multiple && is_array($value) === false) {
            throw new UnexpectedValueException($value, Equipment::class . '[]');
        }

        $value = is_array($value) ? $value : [$value];
        foreach ($value as $item) {
            if ($item instanceof Equipment === false) {
                throw new UnexpectedValueException($item, Equipment::class);
            }

            if (
                is_string($constraint->manufacturingLicense) &&
                $item->getManufacturingLicense() !== $constraint->manufacturingLicense
            ) {
                $licenseTranslationPrefix = 'tools.manufacturing_summary.manufacturing_license.choice.';
                $expectedLicense = $this->translator->trans($licenseTranslationPrefix . $item->getManufacturingLicense());
                $actualLicense = $this->translator->trans($licenseTranslationPrefix . $constraint->manufacturingLicense);
                $this->context
                    ->buildViolation(
                        "L'équipement ne peut être fabriqué que par le métier {$expectedLicense} " .
                        "or il s'agit du contexte du métier {$actualLicense}."
                    )
                    ->setCode('4b04d52c-a7ca-4765-807a-0fc8eeb9622f')
                    ->addViolation();

                return;
            }

            if (
                is_string($constraint->enhancementLicense) &&
                $item->getEnhancementLicense() !== $constraint->enhancementLicense
            ) {
                $licenseTranslationPrefix = 'tools.manufacturing_summary.manufacturing_license.choice.';
                $expectedLicense = $this->translator->trans($licenseTranslationPrefix . $item->getEnhancementLicense());
                $actualLicense = $this->translator->trans($licenseTranslationPrefix . $constraint->enhancementLicense);
                $this->context
                    ->buildViolation(
                        "L'équipement ne peut être amélioré que par le métier {$expectedLicense} " .
                        "or il s'agit du contexte du métier {$actualLicense}."
                    )
                    ->setCode('5513c025-1836-4a2b-82e4-01abb429dda8')
                    ->addViolation();

                return;
            }
        }
    }

}
