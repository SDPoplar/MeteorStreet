<?php
namespace Mxs\Services\Redis;

interface RedisFacadeInterface
{
    public function get(string $key): mixed;
    public function set(string $key, mixed $value, mixed $options = null): \Redis|string|bool;
    public function del(array|string $key, string ...$other_keys): \Redis|int|false;
}