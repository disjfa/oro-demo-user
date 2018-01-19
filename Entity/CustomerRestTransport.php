<?php

namespace Disjfa\DemoBundle\Entity;


use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 */
class CustomerRestTransport extends Transport
{

    /**
     * @var string
     *
     * @ORM\Column(name="demo_rest_endpoint", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $endpoint;

    /**
     * @var string
     *
     * @ORM\Column(name="demo_api_key", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $apiKey;

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return ParameterBag
     */
    public function getSettingsBag()
    {
        return new ParameterBag([
            'endpoint' => $this->endpoint,
            'api_key' => $this->apiKey,
        ]);
    }


}