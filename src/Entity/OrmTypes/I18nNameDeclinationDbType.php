<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nNameDeclinationFieldsVO;
use App\Entity\ValueObjects\I18nNameDeclinationVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class I18nNameDeclinationDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'I18nNameDeclinationDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nNameDeclinationFieldsVO|mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);
        $constructorArg = [];
        foreach ($decoded as $lang => $charField) {
            $constructorArg[$lang] = new I18nNameDeclinationFieldsVO($charField['name'] ?? '-', $charField['declination'] ?? '-');
        }

        return new I18nNameDeclinationVO(...$constructorArg);
    }

}
