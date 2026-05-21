<?php
namespace Mxs\Services\Redis;

use Mxs\Exceptions\Develops\InvalidConfig;

/**
 * @class Redis
 */

abstract class RedisService
{
    protected const string CONNECT = '';

    public function __construct()
    {
        $this->cfg_key = rtrim('redis.' . static::CONNECT, '.');
        if (!array_key_exists($this->cfg_key, static::$all_ins)) {
            $cfg = config($this->cfg_key);
            ($cfg instanceof RedisConfig) or throw new InvalidConfig($this->cfg_key, RedisConfig::class);
            $ins = new RedisInstance($cfg);
            
            static::$all_ins[$this->cfg_key] = $ins;
        }
    }

    protected function getRedisIns(): RedisFacadeInterface
    {
        return static::$all_ins[$this->cfg_key];
    }

    private static array $all_ins = [];
    private string $cfg_key;
}
