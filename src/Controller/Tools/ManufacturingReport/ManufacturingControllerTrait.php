<?php

declare(strict_types=1);

namespace App\Controller\Tools\ManufacturingReport;

use App\{
    Controller\Tools\ToolRenderingTrait,
    Form\Tools\ManufacturingSummaryType,
    Model\Tools\ManufacturingSummary
};
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait ManufacturingControllerTrait
{
    use ToolRenderingTrait;

    protected function createManufacturingForm(?ManufacturingSummary $summary = null, array $specificOptions = []): FormInterface
    {
        return $this->createForm(
            ManufacturingSummaryType::class,
            $summary ?? new ManufacturingSummary(),
            $this->getFormOptions($specificOptions)
        );
    }

    protected function renderIndexResponse(array $requestParameters): Response
    {
        return $this->render('tools/manufacturing_report/index.html.twig', $requestParameters);
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
