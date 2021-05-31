<?php

declare(strict_types=1);

namespace App\Controller\Tools\TradingPost\Stock;

use App\DBAL\CollectingLicenseType;
use App\Repository\TradingPostStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetController extends AbstractController
{
    /**
     * [TWIG] Page présentant les stocks actuels des ressources.
     *
     * @Route("/hôtel-des-ventes/stocks", name="app.tools.trading_post.stocks.get", methods={"GET"})
     */
    public function __invoke(TradingPostStockRepository $repository): Response
    {
        return $this->render(
            'tools/trading_post/stock/index.html.twig',
            [
                'stock_list_hunter' => $repository->findByCollectingLicense(CollectingLicenseType::LICENSE_HUNTER),
                'stock_list_logger' => $repository->findByCollectingLicense(CollectingLicenseType::LICENSE_LOGGER),
                'stock_list_miner' => $repository->findByCollectingLicense(CollectingLicenseType::LICENSE_MINER),
            ]
        );
    }
}
