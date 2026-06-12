<?php
namespace Mxs\Services\Redis;

/**
 * @see https://github.com/phpredis/phpredis/blob/develop/redis.stub.php
 */
interface RedisFacadeInterface
{
    public function get(string $key): mixed;
    public function set(string $key, mixed $value, mixed $options = null): \Redis|string|bool;
    public function del(array|string $key, string ...$other_keys): \Redis|int|false;
    public function hGet(string $key, string $member): mixed;
    public function hDel(string $key, string $field, string ...$other_fields): \Redis|int|false;
    public function hExists(string $key, string $field): \Redis|bool;
    public function hGetAll(string $key): \Redis|array|false;
    public function hIncrBy(string $key, string $field, int $value): \Redis|int|false;
    
    /**
     * Retrieve all of the fields of a hash.
     *
     * @param string $key The hash to query.
     *
     * @return Redis|list<string>|false The fields in the hash or false if the hash doesn't exist.
     *
     * @see https://redis.io/docs/latest/commands/hkeys/
     *
     * @example $redis->hkeys('myhash');
     */
    public function hKeys(string $key): \Redis|array|false;

    /**
     * Get the number of fields in a hash.
     * @see https://redis.io/docs/latest/commands/hlen/
     * @param string $key The hash to check.
     * @return Redis|int|false The number of fields or false if the key didn't exist.
     * @example $redis->hlen('myhash');
     */
    public function hLen(string $key): \Redis|int|false;

    /**
     * Add or update one or more hash fields and values.
     *
     * @param string $key                The hash to create/update.
     * @param mixed  ...$fields_and_vals Argument pairs of fields and values. Alternatively, an associative array with the
     *                                   fields and their values.
     *
     * @return Redis|int|false The number of fields that were added, or false on failure.
     *
     * @see https://redis.io/docs/latest/commands/hset/
     *
     * @example $redis->hSet('player:1', 'name', 'Kim', 'score', 78);
     * @example $redis->hSet('player:1', ['name' => 'Kim', 'score' => 78]);
     */
    public function hSet(string $key, mixed ...$fields_and_vals): \Redis|int|false;

    /**
     * Set a hash field and value, but only if that field does not exist
     *
     * @param string $key   The hash to update.
     * @param string $field The value to set.
     *
     * @return Redis|bool True if the field was set and false if not.
     *
     * @see https://redis.io/docs/latest/commands/hsetnx/
     *
     * @example
     * $redis->hsetnx('player:1', 'lock', 'enabled');
     * $redis->hsetnx('player:1', 'lock', 'enabled');
     */
    public function hSetNx(string $key, string $field, mixed $value): \Redis|bool;
}