<?php

namespace Alms\Bundle\DataGridBundle\ValueResolver;

use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\Input\ArrayInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GridFactoryValueResolver implements ValueResolverInterface
{
    public function __construct(
        protected Compiler $compiler
    )
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() === GridFactoryInterface::class or $argument->getType() === GridFactory::class) {
            return [new GridFactory($this->compiler, new ArrayInput($request->query->all() + $request->request->all()))];
        }

        return [];
    }
}