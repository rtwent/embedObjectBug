<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;

final class I18nNameDeclinationVO extends I18nVO
{
    /**
     * @param I18nNameDeclinationFieldsVO|null $ru
     * @param I18nNameDeclinationFieldsVO|null $ua
     */
    public function __construct(
        ?I18nNameDeclinationFieldsVO $ru,
        ?I18nNameDeclinationFieldsVO $ua
    )
    {
        $this->ru = $ru;
        $this->ua = $ua;
    }

    /**
     * @return I18nNameDeclinationFieldsVO|null
     */
    public function getRu(): ?I18nNameDeclinationFieldsVO
    {
        return $this->ru;
    }

    /**
     * @return I18nNameDeclinationFieldsVO|null
     */
    public function getUa(): ?I18nNameDeclinationFieldsVO
    {
        return $this->ua;
    }

    public function singleLanguage(string $lang): I18nNameDeclinationFieldsVO
    {
        if (!property_exists($this, $lang)) {
            return new I18nNameDeclinationFieldsVO("-", "-");
        }

        /** @var I18nNameDeclinationFieldsVO $singleTranslation */
        $singleTranslation = parent::singleLanguage($lang);

        return $singleTranslation;
    }
}
