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

    $services->set(BetweenWriter::class, BetweenWriter::class);
    $services->set(QueryWriter::class, QueryWriter::class);

    $services->set('data_grid.value_resolver', GridFactoryValueResolver::class)
        ->args([
            service('data_grid.compiler')
        ])
        ->tag('controller.argument_value_resolver');
};