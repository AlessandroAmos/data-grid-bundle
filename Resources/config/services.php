<?php

declare(strict_types=1);

use Alms\Bundle\DataGridBundle\ValueResolver\GridFactoryValueResolver;
use Alms\Bundle\DataGridBundle\Writer\BetweenWriter;
use Alms\Bundle\DataGridBundle\Writer\QueryWriter;
use Spiral\DataGrid\Compiler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {

    $services = $container->services();

    $services->set('data_grid.compiler', Compiler::class);

    $services->set('data_grid.writer.between', BetweenWriter::class);
    $services->set('data_grid.writer.query', QueryWriter::class);

    $services->alias(QueryWriter::class, 'data_grid.writer.query');
    $services->alias(BetweenWriter::class, 'data_grid.writer.between');

    $services->set('data_grid.value_resolver', GridFactoryValueResolver::class)
        ->args([
            service('data_grid.compiler')
        ])
        ->tag('controller.argument_value_resolver');
};