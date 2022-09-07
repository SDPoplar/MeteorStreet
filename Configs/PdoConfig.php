<?php
namespace Mxs\Configs;

class PdoConfig
{
    public function __construct(
        public readonly string $dsn,
        public readonly string $user_name = 'root',
        public readonly string $password = '',
        public readonly array $options = [],
    ) {}

    public static function build(
        \Mxs\Configs\PdoTypes $type,
        string $host = 'localhost',
        int $port = 3306,
        string $database,
        string $user_name = 'root',
        string $password = '',
        array $options = [],
    ): self {
        $dsn = match($type) {
            default => "{$type->name}:{$database}@{$host}:{$port}",
        };
        return new self($dsn, $user_name, $password, $options);
    }
}
