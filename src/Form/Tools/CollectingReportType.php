<?php

namespace App\Form\Tools;

use App\FormHandler\Tools\CollectingReportHandler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

/**
 * Formulaire pour l'outil "collecting_report" permettant de gérer le rapport des métiers de récolte.
 */
class CollectingReportType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('character', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('race', ChoiceType::class, [
                'label' => 'Race',
                'choices' => [
                    'Abyssal' => 'abyssal',
                    'Djöllfulin' => 'djollfulin',
                    'Elfe' => 'elf',
                    'Géant' => 'giant',
                    'Humain' => 'human',
                    'Hybride' => 'hybrid',
                    'Naga' => 'naga',
                    'Nain' => 'dwarf',
                    'Peau verte' => 'green_skin',
                    'Stryge blanc' => 'white_stryge',
                    'Stryge noir' => 'black_stryge',
                    'Thérianthrope' => 'therianthrope',
                    'Vampire' => 'vampire',
                ],
            ])
            ->add('collecting_license', ChoiceType::class, [
                'label' => 'Métier de récolte',
                'choices' => [
                    'Bûcheron' => CollectingReportHandler::LICENSE_LOGGER,
                    'Chasseur' => CollectingReportHandler::LICENSE_HUNTER,
                    'Mineur'   => CollectingReportHandler::LICENSE_MINER,
                ],
            ])
            ->add('crafting_experience', NumberType::class, [
                'label' => 'Points métier',
                'attr' => [
                    'min' => 0,
                    'max' => 200,
                ],
                'constraints' => [
                    new PositiveOrZero(),
                    new LessThanOrEqual(['value' => 200])
                ],
                'html5' => true,
            ])
            ->add('collecting_area', ChoiceType::class, [
                'label' => 'Zone de récolte',
                'choices' => [
                    'Novice' => 'novice',
                    'Apprenti' => 'apprentice',
                    'Compagnon' => 'journeyman',
                    'Expert' => 'expert',
                    'Maître' => 'master',
                    'Djöllfulin - Bambou' => 'djollfulin-bamboo',
                    'Djöllfulin - Tamahagane' => 'djollfulin-tamehagane',
                ],
            ])
            ->add('additional_reward', TextType::class, [
                'label' => 'Récompense de bon RP',
                'required' => false,
            ])
            ->add('collecting_quest', ChoiceType::class, [
                'label' => 'Quête(s) réalisée(s)',
                'required' => false,
                'choices' => [
                    'Première récolte d\'apprenti' => 'apprentice',
                    'Première récolte de compagnon' => 'journeyman',
                    'Première récolte d\'expert' => 'expert',
                    'Première récolte de maître' => 'master',
                    'Persévérant' => 'perseverant',
                    'Liste de mots' => 'word_list',
                    'La disparition' => 'without_them',
                ],
                'multiple' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'Générer',
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
