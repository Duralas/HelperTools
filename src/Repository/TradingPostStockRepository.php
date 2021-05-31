<?php

declare(strict_types=1);

namespace App\Repository;

use App\{
    DBAL\CollectingLicenseType,
    DBAL\TradingPostStockType,
    Entity\TradingPostStock
};
use Doctrine\{
    Bundle\DoctrineBundle\Repository\ServiceEntityRepository,
    Persistence\ManagerRegistry
};

/**
 * @method TradingPostStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradingPostStock[]    findAll()
 * @method TradingPostStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradingPostStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradingPostStock::class);
    }

    /** @return array<TradingPostStock> */
    public function findByCollectingLicense(string $collectingLicense): array
    {
        switch ($collectingLicense) {
            case CollectingLicenseType::LICENSE_HUNTER:
                $type = TradingPostStockType::TYPE_STOCK_HUNTER;

                break;
            case CollectingLicenseType::LICENSE_LOGGER:
                $type = TradingPostStockType::TYPE_STOCK_LOGGER;

                break;
            case CollectingLicenseType::LICENSE_MINER:
                $type = TradingPostStockType::TYPE_STOCK_MINER;

                break;
            default:
                return [];
        }

        return $this
            ->createQueryBuilder('s')
            ->select('s, i')
            ->join('s.item', 'i')
            ->where('s.type = :type')
            ->setParameter('type', $type)
            ->orderBy('s.value')
            ->addOrderBy('i.registration')
            ->getQuery()
            ->getResult();
    }
}
