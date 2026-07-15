<?php


namespace PaLabs\DatagridBundle\Util;


use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DoctrineIterator
{
    public const int PAGE_SIZE = 50;

    /**
     * @param QueryBuilder $qb
     * @param int|null $itemsCount
     * @param int $pageSize
     * @return \Generator<array> generator of batch of entities
     * @throws \Exception
     */
    public static function iterator(
        QueryBuilder $qb,
        ?int $itemsCount = null,
        int $pageSize = self::PAGE_SIZE): \Generator
    {
        if ($itemsCount === null) {
            $itemsCount = self::count($qb);
        }

        $queryCount = (int)($itemsCount / $pageSize);
        if ($pageSize * $queryCount < $itemsCount) {
            $queryCount++;
        }

        for ($queryNumber = 0; $queryNumber < $queryCount; $queryNumber++) {
            $currentQb = clone $qb;
            $currentQb
                ->setFirstResult($queryNumber * $pageSize)
                ->setMaxResults($pageSize);

            $localPaginator = new Paginator($currentQb->getQuery(), true);
            $localPaginator->setUseOutputWalkers(false);
            $localIterator = $localPaginator->getIterator();
            yield iterator_to_array($localIterator);
        }
    }

    public static function count(QueryBuilder $qb): int
    {
        $query = $qb->getQuery();
        $paginator = new Paginator($query, true);

        return $paginator->count();
    }


}