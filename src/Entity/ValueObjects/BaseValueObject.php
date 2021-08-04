<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

class BaseValueObject
{
    protected function filterEmptyParam(string $value, string $paramName = ""): string
    {
        if (empty($value)) {
            throw new ValueObjectConstraint(sprintf("Value of parameter %s can not be empty", $paramName));
        }

        return $value;
    }

    protected function filterIntegerParam(string $value, string $paramName = ""): int
    {
        if (!is_numeric($value)) {
            throw new ValueObjectConstraint(sprintf("Value of parameter %s is not numeric", $paramName));
        }

        return (int)$value;
    }
}
