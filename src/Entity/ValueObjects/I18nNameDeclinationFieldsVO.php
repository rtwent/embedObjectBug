<?php
declare(strict_types=1);

namespace App\Entity\ValueObjects;


use App\Interfaces\ToArray;

final class I18nNameDeclinationFieldsVO extends BaseValueObject implements \JsonSerializable, ToArray
{
    /**
     * @var string
     */
    private ?string $name;
    /**
     * @var string
     */
    private ?string $declination;


    /**
     * I18nNameDeclinationFieldsVO constructor.
     * Дефолтные null значения обеспечиваются для того, чтобы при десериализации не возникало ошибки и данные передавались бы в валидатор.
     * Например: при след. структуре "i18n": {"ru": { "name2": "string",  "declination": "string" }
     * Нормалайзер выкинет ошибку и будет видно исключение нормалайзера а не валидатора App\Services\Validators\I18nNameDeclinationValidator
     * @see https://symfonycasts.com/screencast/api-platform/serialization-tricks#constructor-argument-can-change-validation-errors
     *
     * @param string|null $name
     * @param string|null $declination
     */
    public function __construct(?string $name = null, ?string $declination = null)
    {
        $this->name = $name;
        $this->declination = $declination;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'declination' => $this->declination,
        ];
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDeclination(): ?string
    {
        return $this->declination;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $declination
     */
    public function setDeclination(string $declination): void
    {
        $this->declination = $declination;
    }


}
