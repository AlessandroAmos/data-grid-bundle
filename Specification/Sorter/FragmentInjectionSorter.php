<?php

declare(strict_types=1);

namespace Alms\Bundle\DataGridBundle\Specification\Sorter;

use Alms\Bundle\DataGridBundle\Specification\Sorter\InjectionSorter;
use Cycle\Database\Injection\Fragment;

final class FragmentInjectionSorter extends InjectionSorter
{
    protected const INJECTION = Fragment::class;
}
