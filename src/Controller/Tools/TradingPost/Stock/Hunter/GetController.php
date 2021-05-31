<?php

declare(strict_types=1);

namespace App\Controller\Tools\TradingPost\Stock\Hunter;

use App\{
    Controller\Tools\TradingPost\Stock\StockGetControllerTrait,
    DBAL\CollectingLicenseType,
    Repository\TradingPostStockRepository
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetController extends AbstractController
{
    use StockGetControllerTrait;

    /**
     * [TWIG] Page présentant les stocks actuels des trophées de chasse.
     *
     * @Route("/hôtel-des-ventes/stocks/chasseurs", name="app.tools.trading_post.stocks.hunter.get", methods={"GET"})
     */
    public function __invoke(TradingPostStockRepository $repository): Response
    {
        return $this->renderCollectingLicenseStock($repository, CollectingLicenseType::LICENSE_HUNTER);
    }
}
