<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\ValueObjects\I18nNameDeclinationVO;
use App\Enums\GeoTypesEnum;
use App\Repository\CachedGeoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Index as INDEX;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use App\Services\Validators\I18nNameDeclination;

/**
 * @ORM\Table(name="cached_geo", indexes={@INDEX(name="cached_geo_id", columns={"id"})})
 * @ORM\Entity(repositoryClass=CachedGeoRepository::class)
 * @UniqueEntity("id")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ApiResource(
 *     paginationItemsPerPage=10,
 *     formats={"jsonld", "json"}
 * )
 */
class CachedGeo
{
    /**
     * The id of the geo
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private Uuid $id;

    /**
     * I18n data of geo
     * @ORM\Column(type="I18nNameDeclinationDbType", options={"jsonb":true, "default":"{}"})
     * @Assert\Type(type="App\Entity\ValueObjects\I18nNameDeclinationVO")
     * @Assert\Valid
     * @I18nNameDeclination()
     */
    private I18nNameDeclinationVO $i18n;

    /**
     * Left key of geo nested sets
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value="1")
     */
    private int $lft;

    /**
     * Right key of geo nested sets
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value="1")
     */
    private int $rgt;

    /**
     * Дата создания
     * @var DateTimeInterface|null
     * @ORM\Column(type="datetime", name="created_at")
     * @Gedmo\Timestampable(on="create")
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface|null
     * @ORM\Column(type="datetime", name="updated_at")
     * @Gedmo\Timestampable(on="update")
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", name="deleted_at", nullable=true)
     */
    private ?DateTimeInterface $deletedAt;


    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return I18nNameDeclinationVO
     */
    public function getI18n(): I18nNameDeclinationVO
    {
        return $this->i18n;
    }

    /**
     * @return int
     */
    public function getLft(): int
    {
        return $this->lft;
    }

    /**
     * @return int
     */
    public function getRgt(): int
    {
        return $this->rgt;
    }

    /**
     * @param I18nNameDeclinationVO $i18n
     */
    public function setI18n(I18nNameDeclinationVO $i18n): void
    {
        $this->i18n = $i18n;
    }

    /**
     * @param int $lft
     */
    public function setLft(int $lft): void
    {
        $this->lft = $lft;
    }

    /**
     * @param int $rgt
     */
    public function setRgt(int $rgt): void
    {
        $this->rgt = $rgt;
    }








}
