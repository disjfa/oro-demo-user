<?php

namespace Disjfa\DemoBundle\Provider;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;

class DemoChannelType implements ChannelInterface
{
    /**
     * Returns label for UI
     *
     * @return string
     */
    public function getLabel()
    {
        return 'disjfa_demo';
    }
}