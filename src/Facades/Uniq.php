<?php

namespace Aplr\Toolbox\Facades;

use Illuminate\Support\Facades\Facade;

class Uniq extends Facade
{
    
    /**
     * Get the registered component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uniq';
    }
}
