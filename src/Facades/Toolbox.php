<?php 

namespace Aplr\Toolbox;

use Illuminate\Support\Facades\Facade;

class Toolbox extends Facade {
    
    /**
     * Get the registered component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'toolbox';
    }
    
}