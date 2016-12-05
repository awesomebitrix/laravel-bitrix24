<?php
namespace Antsupovsa\Bitrix\Facades;

use Illuminate\Support\Facades\Facade;

class Bitrix extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bitrix';
    }
}