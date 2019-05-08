<?php

namespace Lucia\Permission\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static array permit(string $pmtCode,bool $isW)
 * @method static array ticket2Session(string $ticket)
 * @method static array publish()
 */
class Sp extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amdbl.sp';
    }

}