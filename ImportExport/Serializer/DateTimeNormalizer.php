<?php
/*
 * (c) H1 Webdevelopment <contact@h1.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Disjfa\DemoBundle\ImportExport\Serializer;

use Symfony\Component\Serializer\Exception\RuntimeException;
use Oro\Bundle\ImportExportBundle\Serializer\Normalizer\DateTimeNormalizer as BaseNormalizer;
use Oro\Bundle\ImportExportBundle\Serializer\Normalizer\DenormalizerInterface;
use Oro\Bundle\ImportExportBundle\Serializer\Normalizer\NormalizerInterface;
use Oro\Bundle\ImportExportBundle\Serializer\Serializer;

class DateTimeNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @var BaseNormalizer
     */
    private $prestashopNormalizer;

    /**
     * @var BaseNormalizer
     */
    private $isoNormalizer;

    /**
     * @var BaseNormalizer
     */
    private $dateNormalizer;

    public function __construct()
    {
        $this->prestashopNormalizer = new BaseNormalizer('Y-m-d H:i:s', 'Y-m-d', 'H:i:s', 'UTC');
        $this->isoNormalizer  = new BaseNormalizer(\DateTime::ISO8601, 'Y-m-d', 'H:i:s', 'UTC');
        $this->dateNormalizer = new BaseNormalizer('Y-m-d', 'Y-m-d', 'H:i:s', 'UTC');
    }
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        try {
            return $this->prestashopNormalizer->denormalize($data, $class, $format, $context);
        } catch (RuntimeException $e) {
            return $this->dateNormalizer->denormalize($data, $class, $format, $context);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return $this->prestashopNormalizer->normalize($object, $format, $context);
    }
    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = array())
    {
        return $this->prestashopNormalizer->supportsDenormalization($data, $type, $format, $context)
            && !empty($context[Serializer::PROCESSOR_ALIAS_KEY])
            && strpos($context[Serializer::PROCESSOR_ALIAS_KEY], 'disjfa_demo') !== false;
    }
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, array $context = array())
    {
        return $this->prestashopNormalizer->supportsNormalization($data, $format, $context)
            && !empty($context[Serializer::PROCESSOR_ALIAS_KEY])
            && strpos($context[Serializer::PROCESSOR_ALIAS_KEY], 'disjfa_demo') !== false;
    }
}