<?php

declare(strict_types=1);

namespace App\Controller\Tools\ManufacturingReport;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetController extends AbstractController
{
    use ManufacturingControllerTrait;

    /**
     * [TWIG] Page de base de l'outil "manufacturing_report".
     *
     * Affiche le formulaire pour construire le rapport de fabrication.
     *
     * @Route("/outils/rapport-de-fabrication", name="app.tools.manufacturing_report.get", methods={"GET"})
     */
    public function __invoke(): Response
    {
        return $this->getToolRenderingResponse($this->createManufacturingForm());
    }
}
