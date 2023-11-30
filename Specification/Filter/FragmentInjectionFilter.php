<?php

declare(strict_types=1);

namespace Alms\Bundle\DataGridBundle\Specification\Filter;

use Alms\Bundle\DataGridBundle\Specification\Filter\InjectionFilter;
use Cycle\Database\Injection;

class FragmentInjectionFilter extends InjectionFilter
{
    protected const INJECTION = Injection\Fragment::class;
}
