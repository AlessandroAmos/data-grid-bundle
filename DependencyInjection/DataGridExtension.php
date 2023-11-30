<?php

namespace Alms\Bundle\DataGridBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class DataGridExtension extends Extension
{

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $compilerDefinition = $container->getDefinition('data_grid.compiler');

        $config['compiler']['writers'] ??= [
            'data_grid.writer.between',
            'data_grid.writer.query',
        ];

        foreach ($config['compiler']['writers'] as $writer) {

            if (!$container->hasDefinition($writer)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" not found', $writer));
            }

            $compilerDefinition->addMethodCall('addWriter', [new Reference($writer)]);
        }
    }
}