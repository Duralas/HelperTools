<?php

declare(strict_types=1);

namespace App\Controller\Tools;

use App\{
    Form\Tools\ManufacturingSummaryType,
    FormHandler\Tools\ManufacturingReportHandler,
    Model\Tools\ManufacturingSummary
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request as SymfonyRequest,
    Response as SymfonyResponse
};
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour l'outil "manufacturing_report" permettant de gérer le rapport des métiers de manufacture.
 */
final class ManufacturingReportController extends AbstractController
{
    use ToolControllerTrait;

    /**
     * [TWIG] Page de base de l'outil "manufacturing_report".
     *
     * Affiche le formulaire pour construire le rapport de fabrication.
     *
     * @Route("/tools/manufacturing-report", name="tools_manufacturing_report", methods={"GET"})
     */
    public function index(): SymfonyResponse
    {
        return $this
            ->getToolRenderingResponse(
                $this->createForm(ManufacturingSummaryType::class, new ManufacturingSummary(), [
                    'method' => SymfonyRequest::METHOD_POST,
                    'action' => $this->generateUrl('tools_manufacturing_reports_generation'),
                ])
            );
    }

    /**
     * [TWIG] Traitement de "génération" lié à l'outil "manufacturing_report".
     *
     * Gère la soumission du formulaire {@see ManufacturingSummaryType} pour réaliser la génération du template de l'outil et affiche le résultat sur la page.
     *
     * En cas d'erreur, affiche également ces erreurs.
     *
     * @Route("/tools/manufacturing-report", name="tools_manufacturing_reports_generation", methods={"POST"})
     */
    public function generate(SymfonyRequest $request, ManufacturingReportHandler $formHandler): SymfonyResponse
    {
        $manufacturingSummary = new ManufacturingSummary();
        // Récupération du formulaire
        $manufacturingReportForm = $this
            ->createForm(ManufacturingSummaryType::class, $manufacturingSummary, [
                'method' => SymfonyRequest::METHOD_POST,
                'action' => $this->generateUrl('tools_manufacturing_reports_generation'),
            ])
            ->handleRequest($request)
        ;

        return $this->getToolRenderingResponse(
            $manufacturingReportForm,
            $manufacturingReportForm->isValid() ? $formHandler->generateTemplate($manufacturingSummary) : null
        );
    }

    protected function renderIndexResponse(array $requestParameters): SymfonyResponse
    {
        return $this->render('tools/manufacturing_report/index.html.twig', $requestParameters);
    }
}
