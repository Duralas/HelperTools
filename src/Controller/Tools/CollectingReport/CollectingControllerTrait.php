<?php

declare(strict_types=1);

namespace App\Controller\Tools\CollectingReport;

use App\{
    Controller\Tools\ToolRenderingTrait,
    Form\Tools\CollectingSummaryType,
    Model\Tools\CollectingSummary
};
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait CollectingControllerTrait
{
    use ToolRenderingTrait;

    protected function createCollectingForm(?CollectingSummary $summary = null, array $specificOptions = []): FormInterface
    {
        return $this->createForm(
            CollectingSummaryType::class,
            $summary ?? new CollectingSummary(),
            $this->getFormOptions($specificOptions)
        );
    }

    protected function renderIndexResponse(array $requestParameters): Response
    {
        return $this->render('tools/collecting_report/index.html.twig', $requestParameters);
    }

    protected function generateSubmitUrl(): string
    {
        return $this->generateUrl(PostController::ROUTE_NAME);
    }

    /**
     * @param mixed $data
     * @param array<mixed> $options
     */
    abstract protected function createForm(string $type, $data = null, array $options = []): FormInterface;

    /** @param array<mixed> $parameters */
    abstract protected function generateUrl(string $route, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string;

    /** @param array<mixed> $parameters */
    abstract protected function render(string $view, array $parameters = [], Response $response = null): Response;
}
