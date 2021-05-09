<?php

declare(strict_types=1);

namespace App\Controller\Tools\ManufacturingReport;

use App\{
    FormHandler\Tools\ManufacturingReportHandler,
    Model\Tools\ManufacturingSummary
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;

final class PostController extends AbstractController
{
    use ManufacturingControllerTrait;

    public const ROUTE_NAME = 'app.tools.manufacturing_report.post';

    /**
     * [TWIG] Traitement de "génération" lié à l'outil "manufacturing_report".
     *
     * Gère la soumission du formulaire {@see ManufacturingSummaryType} pour réaliser la génération du template de l'outil et affiche le résultat sur la page.
     *
     * En cas d'erreur, affiche également ces erreurs.
     *
     * @Route("/outils/rapport-de-fabrication", name=PostController::ROUTE_NAME, methods={"POST"})
     */
    public function __invoke(Request $request, ManufacturingReportHandler $formHandler): Response
    {
        $collectingSummary = new ManufacturingSummary();
        $collectingReportForm = $this
            ->createManufacturingForm($collectingSummary)
            ->handleRequest($request);

        return $this->getToolRenderingResponse(
            $collectingReportForm,
            $collectingReportForm->isValid() ? $formHandler->generateTemplate($collectingSummary) : null
        );
    }
}
