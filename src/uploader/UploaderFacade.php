<?php namespace Arthur\Uploader;

use Illuminate\Support\Facades\Facade;

class UploaderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}
