<?php

namespace JJ\WeddingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JJWeddingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ( $config['dirs'] as $label => $value ) {
                $dirs[$label] = ($value?$value.'/':'')
                .(( 'default' == $label || 'temp' == $label )?'':$label);
        }

        if ( isset( $dirs ) ) {
            $container->setParameter( "dirs", $dirs );
        } else {
            $container->setParameter( "dirs", null );
        }
    }
}
