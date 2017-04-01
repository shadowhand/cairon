<?php

namespace Cairon\Fixture;

use Auryn\Injector as Auryn;

class Config
{
    public function __invoke(Auryn $injector)
    {
        $injector->share(Shared::class);
    }
}
