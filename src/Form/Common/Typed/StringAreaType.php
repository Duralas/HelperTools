<?php

declare(strict_types=1);

namespace App\Form\Common\Typed;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StringAreaType extends StringType
{
    public function getParent(): string
    {
        return TextareaType::class;
    }
}
