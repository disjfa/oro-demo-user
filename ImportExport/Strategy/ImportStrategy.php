<?php
/*
 * (c) H1 Webdevelopment <contact@h1.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Disjfa\DemoBundle\ImportExport\Strategy;

use Doctrine\Common\Util\ClassUtils;
use Oro\Bundle\ImportExportBundle\Strategy\Import\ConfigurableAddOrReplaceStrategy;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class ImportStrategy extends ConfigurableAddOrReplaceStrategy implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeProcessEntity($entity)
    {
        if ($this->logger) {
            $this->logger->info('Syncing Customer [origin_id=' . $entity->getRemoteId() . ']');
        }
        return parent::beforeProcessEntity($entity);
    }

    /**
     * {@inheritdoc}
     */
    protected function findExistingEntity($entity, array $searchContext = array())
    {
        $entityName = ClassUtils::getClass($entity);
        $existingEntity = null;
        // find by identity fields
        if (!$searchContext || $this->databaseHelper->getIdentifier(current($searchContext))
        ) {
            $identityValues = $searchContext;
            $identityValues += $this->fieldHelper->getIdentityValues($entity);
            // add channel filter for finding existing entity
            $identityValues += ['channel' => $entity->getChannel()];
            $existingEntity = $this->findEntityByIdentityValues($entityName, $identityValues);
        }
        return $existingEntity;
    }
}