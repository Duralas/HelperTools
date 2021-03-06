<?php

declare(strict_types=1);

namespace App\Controller\Tools\TradingPost\Stock;

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
     * [TWIG] Page présentant la liste des stocks des ressources.
     *
     * @Route("/hôtel-des-ventes/stocks", name="app.tools.trading_post.stocks.get", methods={"GET"})
     */
    public function __invoke(TradingPostStockRepository $repository): Response
    {
        return $this->render('tools/trading_post/stock/index.html.twig');
    }
}
