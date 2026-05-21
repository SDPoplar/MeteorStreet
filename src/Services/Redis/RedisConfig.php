<?php
namespace Mxs\Services\Redis;

final readonly class RedisConfig
{
    public function __construct(
        public string $host = 'localhost',
        public int $port = 6379,
        public string $sock = '',
        public bool $transport_level = false,
        public string $auth = '',
        public int $select = 0,
    ) {}

    public static function host(
        string $host = 'localhost',
        int $port = 6379,
        bool $transport_level = false,
        string $auth = '',
        int $select = 0,
    ): self {
        return new self($host, $port, $transport_level, auth: $auth, select: $select);
    }

    public static function sock(string $sock, string $auth = '', int $select = 0): self
    {
        return new self(sock: $sock, auth: $auth, select: $select);
    }
}
