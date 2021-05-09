<?php

declare(strict_types=1);

namespace App\Controller\Tools\CollectingReport;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetController extends AbstractController
{
    use CollectingControllerTrait;

    /**
     * [TWIG] Page de base de l'outil "collecting_report".
     *
     * Affiche le formulaire pour construire le rapport de récolte de la dernière génération effectuée.
     *
     * @Route("/outils/rapport-de-récolte", name="app.tools.collecting_report.get", methods={"GET"})
     */
    public function __invoke(): Response
    {
        return $this->getToolRenderingResponse($this->createCollectingForm());
    }
}
