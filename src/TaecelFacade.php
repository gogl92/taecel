<?php

namespace Taecel\Taecel;

use Illuminate\Support\Facades\Facade;

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
