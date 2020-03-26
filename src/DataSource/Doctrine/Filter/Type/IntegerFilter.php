<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Integer\IntegerFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Integer\IntegerFilterForm;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;
use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;
use PaLabs\DatagridBundle\DataSource\Filter\Options\FilterOptions;
use PaLabs\DatagridBundle\Util\StringUtils;

class IntegerFilter implements FilterFormProvider, DoctrineFilterInterface
{
    public function formType(): string {
        return IntegerFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public static function options(string $label): BaseFilterOptions {
        return new BaseFilterOptions($label);
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
    {
        if (!$criteria instanceof IntegerFilterData) {
            throw new InvalidFilterDataException(IntegerFilterData::class, $criteria);
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