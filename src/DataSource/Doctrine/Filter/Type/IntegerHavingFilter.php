<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Integer\IntegerFilterForm;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\Util\StringUtils;

class IntegerHavingFilter implements FilterInterface
{

    public static function formData($value) {
        return ['value' => $value];
    }

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