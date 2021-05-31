<?php

declare(strict_types=1);

namespace App\Controller\Tools\TradingPost\Stock;

use App\Repository\TradingPostStockRepository;
use Symfony\Component\HttpFoundation\Response;

trait StockGetControllerTrait
{
    protected function renderCollectingLicenseStock(
        TradingPostStockRepository $repository,
        string $collectingLicense
    ): Response {
        return $this->render(
            'tools/trading_post/stock/stock.html.twig',
            ['stock_list' => $repository->findByCollectingLicense($collectingLicense), 'type' => $collectingLicense]
        );
    }

    /** @param array<mixed> $parameters */
    abstract protected function render(string $view, array $parameters = [], Response $response = null): Response;
}
