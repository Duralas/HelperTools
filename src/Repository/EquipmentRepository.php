<?php

namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipment[]    findAll()
 * @method Equipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    /** @param array<string> $licenses */
    public function getManufacturingQb(array $licenses): QueryBuilder
    {
        return $this
            ->createBaseQb('e')
            ->addSelect('r')
            ->join('e.recipe', 'r')
            ->andWhere('e.manufacturingLicense in (:licenses)')
            ->setParameter('licenses', $licenses);
    }

    /** @param array<string> $licenses */
    public function getEnhancingQb(array $licenses): QueryBuilder
    {
        return $this
            ->createBaseQb('e')
            ->andWhere('e.enhancementLicense in (:licenses)')
            ->setParameter('licenses', $licenses);
    }

    protected function createBaseQb(string $alias): QueryBuilder
    {
        return $this
            ->createQueryBuilder($alias)
            ->orderBy("{$alias}.registration");
    }
}
