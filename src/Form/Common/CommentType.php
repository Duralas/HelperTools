<?php

declare(strict_types=1);

namespace App\Form\Common;

use App\Form\Common\Typed\StringAreaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Commentaire(s)',
        ]);
    }

    public function getParent(): string
    {
        return StringAreaType::class;
    }
}
