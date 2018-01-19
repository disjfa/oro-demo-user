<?php

namespace Disjfa\DemoBundle\Provider;

use Disjfa\DemoBundle\Entity\CustomerRestTransport;
use Disjfa\DemoBundle\Form\Type\RestTransportType;
use Disjfa\DemoBundle\Provider\Transport\RestIterator;
use Oro\Bundle\IntegrationBundle\Exception\InvalidConfigurationException;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Transport\AbstractRestTransport;
use Symfony\Component\HttpFoundation\ParameterBag;

class RestTransport extends AbstractRestTransport
{
    const API_URL_PREFIX = 'users';
    const BATCH_SIZE = 25;

    /**
     * Get REST client base url
     *
     * @param ParameterBag $parameterBag
     * @return string
     * @throws InvalidConfigurationException
     */
    protected function getClientBaseUrl(ParameterBag $parameterBag)
    {
        return rtrim($parameterBag->get('endpoint'), '/') . '/';
    }

    /**
     * Get REST client options
     *
     * @param ParameterBag $parameterBag
     * @return array
     * @throws InvalidConfigurationException
     */
    protected function getClientOptions(ParameterBag $parameterBag)
    {
        return [];
    }

    /**
     * Returns label for UI
     *
     * @return string
     */
    public function getLabel()
    {
        return 'REST';
    }

    /**
     * Returns form type name needed to setup transport
     *
     * @return string
     */
    public function getSettingsFormType()
    {
        return RestTransportType::class;
    }

    /**
     * Returns entity name needed to store transport settings
     *
     * @return string
     */
    public function getSettingsEntityFQCN()
    {
        return CustomerRestTransport::class;
    }

    public function getCustomers($lastUpdatedAt)
    {
        $params = [
            'output_format' => 'JSON',
            'display' => 'full',
            'limit' => self::BATCH_SIZE,
        ];

        if ($lastUpdatedAt) {
            $params['date'] = 1;
        }

        return new RestIterator($this->getClient(), 'users', $params);
    }
}