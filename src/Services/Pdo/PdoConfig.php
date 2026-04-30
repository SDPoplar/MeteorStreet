<?php
namespace Mxs\Services\Pdo;

abstract readonly class PdoConfig
{
    abstract public function getDsn(): string;

    public function __construct(
        public string $user,
        public string $password
    ) {}
}