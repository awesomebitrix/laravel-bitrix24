<?php
namespace Antsupovsa\Bitrix24\Facades;

use Illuminate\Support\Facades\Facade;

class Bitrix24 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Antsupovsa\Bitrix24\Bitrix24::class;
    }
}