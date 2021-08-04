<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Exceptions\OrmType;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Interfaces\ToArray;


class JsonbToArrayType extends Type
{
    /**
     * Name of type
     */
    const TYPE_NAME = 'JsonbToArray';

    /**
     * @return string
     */
    public function getName()
    {
        return static::TYPE_NAME;
    }

    /**
     * Example VARCHAR(255) etc... from dll of the create table
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSONB';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof ToArray) {
            throw new OrmType("Variable value must implement toArray interface.");
        }

        $value = json_encode($value->toArray(), JSON_UNESCAPED_UNICODE);

        return $value;
    }
}
