<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Integer\IntegerFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Integer\IntegerFilterForm;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\Util\StringUtils;

class IntegerFilter implements FilterInterface
{
    public function formType(): string {
        return IntegerFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply($qb, string $name, $criteria, array $options = [])
    {
        if(!$qb instanceof QueryBuilder) {
            throw new \Exception("This filter can only be applies to QueryBuilder");
        }
        if (!$criteria instanceof IntegerFilterData) {
            throw new \Exception();
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);

        $queryParts = [];

        $parts = explode(',', $criteria->getValue());
        $parts = StringUtils::trimStringArray($parts);
        foreach ($parts as $part) {
            if (StringUtils::contains($part, '-')) {
                list($firstPart, $secondPart) = explode('-', $part, 2);
                $localParts = [];
                if (!empty($firstPart)) {
                    $localParts[] = sprintf('%s >= %d', $fieldName, $firstPart);
                }
                if (!empty($secondPart)) {
                    $localParts[] = sprintf('%s <= %d', $fieldName, $secondPart);
                }
                $queryParts[] = implode(' AND ', $localParts);
            } else {
                $queryParts[] = sprintf('%s = %d', $fieldName, $part);
            }
        }
        if (count($queryParts) > 0) {
            $query = implode(' OR ', array_map(function ($item) {
                return '(' . $item . ')';
            }, $queryParts));
            $qb->andWhere($query);
        }
    }
}