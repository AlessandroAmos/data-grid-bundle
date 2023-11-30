<?php

namespace Alms\Bundle\DataGridBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('data_grid');

        $builder->getRootNode()
            ->children()
                ->arrayNode('compiler')
                    ->children()
                        ->arrayNode('writers')
                            ->scalarPrototype()
                            ->info('List of services implementing Spiral\DataGrid\WriterInterface')
                            ->defaultValue([
                                'data_grid.writer.between',
                                'data_grid.writer.query',
                            ])
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}