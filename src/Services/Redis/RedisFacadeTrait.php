<?php
namespace Mxs\Services\Redis;

trait RedisFacadeTrait
{
    #[\Override]
    public function get(string $key): string|false
    {
        try {
            return $this->ins->get($key);
        } catch (\RedisException $e) {
            throw new ConnectServiceFailed('Redis connnect failed', $e);
        };
    }
}
