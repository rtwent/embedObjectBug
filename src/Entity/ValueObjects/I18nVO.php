<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Enums\LangsEnum;
use App\Exceptions\I18n;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;

abstract class I18nVO implements \JsonSerializable, ToArray
{
    protected ?BaseValueObject $ru = null;
    protected ?BaseValueObject $ua = null;

    /**
     * @return BaseValueObject|null
     */
    abstract public function getRu(): ?BaseValueObject;

    /**
     * @return BaseValueObject|null
     */
    abstract public function getUa(): ?BaseValueObject;

    /**
     * @param $name
     * @throws \Exception
     */
    public function __get($name)
    {
        throw new I18n(sprintf("No magic encourage. Property '%s' is absent in class '%s'. Please add desired language.", $name, __CLASS__));
    }

    public function toArray(): array
    {
        $returnArray = [];
        foreach (LangsEnum::values() as $lang) {
            $returnArray[$lang] = $this->{$lang} ?->toArray() ?? [];
        }

        return $returnArray;
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray(), \JSON_UNESCAPED_UNICODE);
    }

    public function singleLanguage(string $lang): BaseValueObject
    {
        if (!LangsEnum::accepts($lang)) {
            throw new ValueObjectConstraint(sprintf("Lang %s is not presented in LangEnum", $lang));
        }

        /** @var BaseValueObject $returnObject */
        $returnObject = $this->{$lang};

        return $returnObject;
    }

}
