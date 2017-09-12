<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\Filter\Form\IntegerFilterForm;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\Util\StringUtils;

class IntegerHavingFilter implements FilterInterface
{

    public static function formData($value) {
        return ['value' => $value];
    }

    public function getDefaultFormType() {
        return IntegerFilterForm::class;
    }

    public function getDefaultFormOptions()
    {
        return [];
    }

    public function apply(QueryBuilder $qb, $name, $criteria, array $options = [])
    {
        if (!isset($criteria['value'])) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);

        $queryParts = [];

        $parts = explode(',', $criteria['value']);
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
            $qb->andHaving($query);
        }
    }
}