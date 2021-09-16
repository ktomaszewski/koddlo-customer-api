<?php

declare(strict_types=1);

namespace Test\Extension;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeFirstTestHook;

final class BypassFinalHook implements BeforeFirstTestHook
{
    public function executeBeforeFirstTest(): void
    {
        BypassFinals::enable();
    }
}
