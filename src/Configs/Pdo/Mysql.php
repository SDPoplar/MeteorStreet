<?php
namespace Mxs\Configs\Pdo;

class MySql extends PdoConfig
{
    public function __construct(
        public readonly string $database,
        public readonly int $port = 3306,
        public readonly string $host = 'localhost',
        string $user = 'root',
        string $password = '',
        public readonly string $charset = 'utf8',
    ) {
        parent::__construct(
            "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}",
            $user,
            $password,
        );
    }
}
