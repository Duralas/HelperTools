<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\{
    Constraints\NotBlank,
    Constraints\NotBlankValidator
};

/** @Annotation */
final class Character extends NotBlank
{
    public $message = 'Le nom du personnage est obligatoire.';

    public function validatedBy(): string
    {
        return NotBlankValidator::class;
    }
}
