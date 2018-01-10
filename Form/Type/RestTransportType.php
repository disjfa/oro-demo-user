<?php

namespace Disjfa\DemoBundle\Form\Type;


use Disjfa\DemoBundle\Entity\RestTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestTransportType extends AbstractType
{
    const BLOCK_PREFIX = 'h1_exact_setting_type';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'endpoint',
            TextType::class,
            [
                'label' => 'disjfa_demo.settings.endpont.label',
                'required' => false,
            ]
        );

        $builder->add(
            'apiKey',
            TextType::class,
            [
                'label' => 'disjfa_demo.settings.api_key.label',
                'required' => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => RestTransport::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return self::BLOCK_PREFIX;
    }
}