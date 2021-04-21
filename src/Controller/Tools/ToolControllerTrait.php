<?php

declare(strict_types=1);

namespace App\Controller\Tools;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait de contrôleur pour la gestion des outils et de leur génération.
 */
trait ToolControllerTrait
{
    /** @param array<mixed> $requestParameters */
    abstract protected function renderIndexResponse(array $requestParameters): Response;

    protected function getToolRenderingResponse(FormInterface $toolForm, ?string $toolGeneration = null): Response
    {
        $requestParameters = ['tool_form' => $toolForm->createView()];
        if (is_string($toolGeneration)) {
            $requestParameters['tool_generation'] = $toolGeneration;
        }

        return $this->renderIndexResponse($requestParameters);
    }
}
