<?php
namespace Mxs\Configs;

class RedisConfig
{
    public function __construct(
        public readonly string $host = 'localhost',
        public readonly int $port = 6379,
        public readonly ?string $auth = null,
        public readonly int $use_db = 0,
        public readonly string $prefix = '',
    ) {}
}
