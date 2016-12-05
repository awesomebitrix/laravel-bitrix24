<?php
/**
 * Created by PhpStorm.
 * User: toor
 * Date: 05.12.16
 * Time: 8:57
 */

namespace Antsupovsa\Bitrix24;

use Illuminate\Support\Arr;

class Bitrix24
{
    /**
     * Illuminate config repository instance.
     *
     * @var array
     */
    protected $config;

    /**
     * @var \Bitrix24\Bitrix24
     */
    protected $bitrix24;

    /**
     * Set api key and optionally API endpoint
     * @param      $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * We can modify internal settings
     * @param $key
     * @param $value
     */
    function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }
}