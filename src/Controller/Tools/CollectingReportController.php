<?php

namespace App\Controller\Tools;

use App\Form\Tools\CollectingReportType;
use App\FormHandler\Tools\CollectingReportHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/outils/rapport-de-récolte", name="tools_collecting_report", methods={"GET"})
     *
     * @return Response Template du formulaire de l'outil
     */
    public function index(): Response
    {
        $collectingReportForm = $this->createForm(CollectingReportType::class, null, [
            'method' => Request::METHOD_POST,
            'action' => $this->generateUrl('tools_collecting_report_generation'),
        ]);

        return $this->getToolRenderingResponse($collectingReportForm);
    }

    /**
     * [TWIG] Traitement de "génération" lié à l'outil "collecting_repost".
     *
     * Gère la soumission du formulaire {@see CollectingReportType} pour réaliser la génération du template de l'outil et affiche le résultat sur la page.
     *
     * En cas d'erreur, affiche également ces erreurs.
     *
     * @Route("/outils/rapport-de-récolte", name="tools_collecting_report_generation", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response Template de la génération (avec le formulaire)
     */
    public function generate(Request $request, CollectingReportHandler $formHandler): Response
    {
        // Récupération du formulaire
        $collectingReportForm = $this
            ->createForm(CollectingReportType::class, null, [
                'method' => Request::METHOD_POST,
                'action' => $this->generateUrl('tools_collecting_report_generation'),
            ])
            ->handleRequest($request)
        ;
        $collectingReportData = $collectingReportForm->getData();

        $generation = $collectingReportForm->isValid() ? $formHandler->generate($collectingReportData) : null;

        // Affichage du template
        return $this->getToolRenderingResponse($collectingReportForm, $generation);
    }

    /**
     * Construit la réponse du template TWIG pour l'outil avec le formulaire et la génération si elle a été réalisée.
     *
     * @param FormInterface $toolForm             Formulaire de l'outil pour la génération
     * @param string|null   $toolGeneration       [Optionnel] Génération de l'outil
     * @param array         $additionalParameters [Optionnel] Paramètres complémentaires pour la requête
     *
     * @return Response Template de l'outil avec les paramètres fournis
     */
    private function getToolRenderingResponse(FormInterface $toolForm, $toolGeneration = null, array $additionalParameters = []): Response
    {
        $additionalParameters['tool_form'] = $toolForm->createView();
        if ($toolGeneration) {
            $additionalParameters['tool_generation'] = $toolGeneration;
        }

        return $this->render('tools/collecting_report/index.html.twig', $additionalParameters);
    }
}
