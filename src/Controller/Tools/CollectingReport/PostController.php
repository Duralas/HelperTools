<?php

declare(strict_types=1);

namespace App\Controller\Tools\CollectingReport;

use App\{
    FormHandler\Tools\CollectingReportHandler,
    Model\Tools\CollectingSummary
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;

final class PostController extends AbstractController
{
    use CollectingControllerTrait;

    public const ROUTE_NAME = 'app.tools.collecting_report.post';

    /**
     * [TWIG] Traitement de "génération" lié à l'outil "collecting_repost".
     *
     * Gère la soumission du formulaire {@see CollectingSummaryType} pour réaliser la génération du template de l'outil et affiche le résultat sur la page.
     *
     * En cas d'erreur, affiche également ces erreurs.
     *
     * @Route("/outils/rapport-de-récolte", name=PostController::ROUTE_NAME, methods={"POST"})
     */
    public function __invoke(Request $request, CollectingReportHandler $formHandler): Response
    {
        $collectingSummary = new CollectingSummary();
        $collectingReportForm = $this
            ->createCollectingForm($collectingSummary)
            ->handleRequest($request);

        return $this->getToolRenderingResponse(
            $collectingReportForm,
            $collectingReportForm->isValid() ? $formHandler->generateTemplate($collectingSummary) : null
        );
    }
}
