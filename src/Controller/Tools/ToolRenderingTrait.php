<?php

declare(strict_types=1);

namespace App\Controller\Tools;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait de contrôleur pour la gestion des outils et de leur génération.
 */
trait ToolRenderingTrait
{
    /** @param array<mixed> $requestParameters */
    abstract protected function renderIndexResponse(array $requestParameters): Response;

    abstract protected function generateSubmitUrl(): string;

    protected function getToolRenderingResponse(FormInterface $toolForm, ?string $toolGeneration = null): Response
    {
        $requestParameters = ['tool_form' => $toolForm->createView()];
        if (is_string($toolGeneration)) {
            $requestParameters['tool_generation'] = $toolGeneration;
        }

        return $this->renderIndexResponse($requestParameters);
    }

    /**
     * @param array<mixed> $specificOptions
     * @return array<mixed>
     */
    protected function getFormOptions(array $specificOptions = []): array
    {
        $specificOptions['method'] = $specificOptions['method'] ?? Request::METHOD_POST;
        $specificOptions['action'] = $specificOptions['action'] ?? $this->generateSubmitUrl();

        return $specificOptions;
    }
}
