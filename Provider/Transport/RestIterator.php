<?php

namespace Disjfa\DemoBundle\Provider\Transport;

use Oro\Bundle\IntegrationBundle\Provider\Rest\Client\AbstractRestIterator;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Client\RestClientInterface;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Exception\RestException;

class RestIterator extends AbstractRestIterator
{
    /**
     * @var string
     */
    private $resource;
    /**
     * @var array
     */
    private $params;

    public function __construct(RestClientInterface $client, $resource, array $params = [])
    {
        parent::__construct($client);

        $this->resource = $resource;
        $this->params = $params;
    }

    /**
     * Load page
     *
     * @param RestClientInterface $client
     * @return array|null
     * @throws RestException
     */
    protected function loadPage(RestClientInterface $client)
    {
        return $client->getJSON($this->resource, $this->params);
    }

    /**
     * Get rows from page data
     *
     * @param array $data
     * @return void
     */
    protected function getRowsFromPageData(array $data)
    {
        dump($data);
        exit;
    }

    /**
     * Get total count from page data
     *
     * @param array $data
     * @param integer $previousValue
     * @return array|null
     */
    protected function getTotalCountFromPageData(array $data, $previousValue)
    {
        if(isset($data[$this->resource])) {
            return count($data[$this->resource]);
        }

        return $previousValue;
    }
}