<?php
declare(strict_types=1);


namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\CachedGeo;
use App\Entity\ValueObjects\I18nNameDeclinationFieldsVO;
use App\Entity\ValueObjects\I18nNameDeclinationVO;
use Doctrine\ORM\EntityManagerInterface;

final class CachedGeoDataPersister implements ContextAwareDataPersisterInterface
{

    private DataPersisterInterface $decoratedDataPersister;
    private EntityManagerInterface $entityManager;

    /**
     * CachedGeoDataPersister constructor.
     * @param DataPersisterInterface $decoratedDataPersister
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(DataPersisterInterface $decoratedDataPersister, EntityManagerInterface $entityManager)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->entityManager = $entityManager;
    }


    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof CachedGeo;
    }

    /**
     * https://github.com/api-platform/core/issues/4293
     * https://github.com/api-platform/core/pull/1534
     *
     * @param CachedGeo $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        if (($context['item_operation_name'] ?? '') === 'patch') {
            $originalData = $this->entityManager->getUnitOfWork()->getOriginalEntityData($data);
            // here $originalData['i18n'] is equals to data that was PATCHed by user
            $this->entityManager->getUnitOfWork()->setOriginalEntityData($data, array_merge($originalData, ['i18n' => null]));
            $data->setI18n($data->getI18n());
        }
        return $this->decoratedDataPersister->persist($data);
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        $this->decoratedDataPersister->remove($data);
    }
}
