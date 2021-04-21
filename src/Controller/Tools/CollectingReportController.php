<?php

declare(strict_types=1);

namespace App\Controller\Tools;

use App\{
    Form\Tools\CollectingSummaryType,
    FormHandler\Tools\CollectingReportHandler,
    Model\Tools\CollectingSummary
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour l'outil "collecting_report" permettant de gérer le rapport des métiers de récolte.
 */
class CollectingReportController extends AbstractController
{
    /**
     * [TWIG] Page de base de l'outil "collecting_report".
     *
     * Affiche le formulaire pour construire le rapport de récolte et la dernière génération effectuée.
     *
     * @Route("/tools/collecting-report", name="tools_collecting_report", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->getToolRenderingResponse(
            $this->createForm(CollectingSummaryType::class, new CollectingSummary(), [
                'method' => Request::METHOD_POST,
                'action' => $this->generateUrl('tools_collecting_report_generation'),
            ])
        );
    }

    /**
     * [TWIG] Traitement de "génération" lié à l'outil "collecting_repost".
     *
     * Gère la soumission du formulaire {@see CollectingSummaryType} pour réaliser la génération du template de l'outil et affiche le résultat sur la page.
     *
     * En cas d'erreur, affiche également ces erreurs.
     *
     * @Route("/tools/collecting-report", name="tools_collecting_report_generation", methods={"POST"})
     */
    public function generate(Request $request, CollectingReportHandler $formHandler): Response
    {
        $collectingSummary = new CollectingSummary();
        // Récupération du formulaire
        $collectingReportForm = $this
            ->createForm(CollectingSummaryType::class, $collectingSummary, [
                'method' => Request::METHOD_POST,
                'action' => $this->generateUrl('tools_collecting_report_generation'),
            ])
            ->handleRequest($request)
        ;

        // Affichage du template
        return $this->getToolRenderingResponse(
            $collectingReportForm,
            $collectingReportForm->isValid() ? $formHandler->generateTemplate($collectingSummary) : null
        );
    }

    /**
     * Construit la réponse du template TWIG pour l'outil avec le formulaire et la génération si elle a été réalisée.
     */
    private function getToolRenderingResponse(FormInterface $toolForm, ?string $toolGeneration = null): Response
    {
        $requestParameters = ['tool_form' => $toolForm->createView()];
        if (is_string($toolGeneration)) {
            $requestParameters['tool_generation'] = $toolGeneration;
        }

        return $this->render('tools/collecting_report/index.html.twig', $requestParameters);
    }
}
