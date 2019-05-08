<?php

namespace Amdbl\Sp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array authUserInfo(string $token)
 * @method static array authUserRequest($request)
 * @method static array redirectBack()
 */
class Splayer extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amdbl.splayer';
    }

}