<?php
namespace Mxs\Configs\Pdo;

abstract class PdoConfig
{
    public function __construct(
        public readonly string $dsn,
        public readonly string $user,
        public readonly string $password,
        public readonly array $options = [],
    ) {}

    public function option(string $opt_name): ?string
    {
        return $this->options[$opt_name] ?? null;
    }
}
