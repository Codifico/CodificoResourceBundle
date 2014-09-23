<?php

namespace Codifico\ResourceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('codifico_resource');

        $rootNode
            ->children()
                ->arrayNode('entities')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('class')->isRequired()->end()
                            ->scalarNode('manager')
                                ->defaultValue('doctrine.orm.default_entity_manager')
                            ->end()
                            ->scalarNode('factory_service')
                                ->defaultValue('codifico.resource.repository_factory')
                            ->end()
                            ->scalarNode('factory_method')
                                ->defaultValue('getRepository')
                            ->end()
                            ->scalarNode('repository_prefix')
                                ->defaultValue('codifico.resource.repository.')
                            ->end()
                            ->scalarNode('repository_class')
                                ->defaultValue(null)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
