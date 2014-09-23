<?php

namespace Codifico\ResourceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CodificoResourceExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['entities'] as $name => $entity) {
            $container
                ->register(
                    $entity['repository_prefix'] . $name,
                    null === $entity['repository_class'] ? 'Doctrine\ORM\EntityRepository' : $entity['repository_class']
                )
                ->setFactoryService($entity['factory_service'])
                ->setFactoryMethod($entity['factory_method'])
                ->setArguments([
                    new Reference($entity['manager']),
                    $entity['class'],
                    $entity['repository_class'],
                ]);
            ;
        }


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
