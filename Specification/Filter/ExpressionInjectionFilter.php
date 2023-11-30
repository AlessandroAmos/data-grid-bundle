<?php

declare(strict_types=1);

namespace Alms\Bundle\DataGridBundle\Specification\Filter;

use Alms\Bundle\DataGridBundle\Specification\Filter\InjectionFilter;
use Cycle\Database\Injection;

class ExpressionInjectionFilter extends InjectionFilter
{
    protected const INJECTION = Injection\Expression::class;
}
