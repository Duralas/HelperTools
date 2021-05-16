<?php

declare(strict_types=1);

namespace App\Form\Common;

use App\Entity\Equipment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Equipment::class,
            'choice_label' => static fn (Equipment $equipment) => $equipment->getName(),
            'choice_value' => static fn (Equipment $equipment) => $equipment->getRegistration(),
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
