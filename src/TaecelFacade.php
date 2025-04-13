<?php

declare(strict_types=1);

namespace Taecel\Taecel;

use Illuminate\Support\Facades\Facade;

/**
 * TaecelFacade
 */
class TaecelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'taecel';
    }
}
