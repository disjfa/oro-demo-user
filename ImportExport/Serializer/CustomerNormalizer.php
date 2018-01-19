<?php

namespace Disjfa\DemoBundle\ImportExport\Serializer;

use Disjfa\DemoBundle\Entity\Customer;
use Oro\Bundle\DotmailerBundle\ImportExport\Serializer\ConfigurableEntityNormalizer;
use Oro\Bundle\EntityBundle\Helper\FieldHelper;
use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerNormalizer extends ConfigurableEntityNormalizer
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    public function __construct(FieldHelper $fieldHelper, RegistryInterface $registry)
    {
        parent::__construct($fieldHelper);
        $this->registry = $registry;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Customer;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        return $type === Customer::class;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        /** @var Customer $customer */
        $customer = parent::denormalize($data, $class, $format, $context);

        dump($data);
        exit;

        $integration = $this->getIntegrationFromContex($context);
        $customer->setChannel($integration);

        return $customer;
    }

    public function getIntegrationFromContex(array $contex)
    {
        if(!isset($contex['channel'])) {
            throw new \LogicException('Context should contain reference to channel');
        }

        return $this->registry
            ->getRepository(Channel::class)
            ->getOrLoadById($contex['channel']);
    }

}