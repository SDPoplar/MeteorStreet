<?php
namespace Mxs\Services\Pdo;

readonly class PdoConfig
{
    public function __construct(
        public string $dsn,
        public string $user,
        public string $password
    ) {}

    public static function sqlite(string $file, string $password = ''): self
    {
        return new self("sqlite:{$file}", '', $password);
    }
}