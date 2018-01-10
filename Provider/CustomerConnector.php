<?php

namespace Disjfa\DemoBundle\Provider;

use Disjfa\DemoBundle\Entity\Customer;
use Oro\Bundle\ImportExportBundle\Context\ContextRegistry;
use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\IntegrationBundle\Entity\Status;
use Oro\Bundle\IntegrationBundle\Logger\LoggerStrategy;
use Oro\Bundle\IntegrationBundle\Provider\AbstractConnector;
use Oro\Bundle\IntegrationBundle\Provider\ConnectorContextMediator;
use Oro\Bundle\IntegrationBundle\Provider\ConnectorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerConnector extends AbstractConnector implements ConnectorInterface
{

    /**
     * @var RegistryInterface
     */
    private $registry;

    public function __construct(
        ContextRegistry $contextRegistry,
        LoggerStrategy $logger,
        ConnectorContextMediator $contextMediator,
        RegistryInterface $registry
    )
    {
        parent::__construct($contextRegistry, $logger, $contextMediator);
        $this->registry = $registry;
    }

    /**
     * Returns label for UI
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Customers';
    }

    /**
     * Returns entity name that will be used for matching "import processor"
     *
     * @return string
     */
    public function getImportEntityFQCN()
    {
        return Customer::class;
    }

    /**
     * Returns job name for import
     *
     * @return string
     */
    public function getImportJobName()
    {
        return 'demo_import_customer';
    }

    /**
     * Returns type name, the same as registered in service tag
     *
     * @return string
     */
    public function getType()
    {
        return 'customer';
    }

    protected function getConnectorSource()
    {
        $this->transport->getCustomers($this->getLastSynchDate());
    }

    public function getLastSynchDate()
    {
        $channel = $this->contextMediator->getChannel($this->getContext());
        $status = $this->registry->getRepository(Channel::class)
            ->getLastStatusForConnector($channel, $this->getType(), Status::STATUS_COMPLETED);

        return $status ? $status->getDate() : null;
    }


}
