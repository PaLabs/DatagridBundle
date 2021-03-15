<?php


namespace PaLabs\DatagridBundle\Grid\UrlBuilder;


class GridUrlParameters
{

    public static function build(
        array $filters = [],
        array $order = [],
        ?int $page = null,
        ?int $perPage = null,
        array $fields = []): array
    {


        $ds = (new GridDataSourceUrlParameters())
            ->addFilters($filters);
        foreach ($order as $orderItem) {
            $ds->addOrder($orderItem);
        }

        if ($page !== null) {
            $ds->setPage($page);
        }

        if ($perPage !== null) {
            $ds->setPerPage($perPage);
        }

        $dt = (new GridDataTableUrlParameters());
        if (count($fields) > 0) {
            $dt->addFields($fields);
        }


        $builder = (new GridUrlParametersBuilder())
            ->setDataSourceParameters($ds)
            ->setDataTableParameters($dt);
        return $builder->build();
    }
}