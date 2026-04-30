<?php
namespace Mxs\Services\Pdo;

use Mxs\Exceptions\Develops\InvalidConfig;

class Sqlite extends PdoService
{
    protected const string CONNECT = '';

    public function __construct()
    {
        $conn_key = rtrim('sqlite.'.static::CONNECT, '.');
        $cfg = config($conn_key);
        ($cfg instanceof SqliteConfig) or throw new InvalidConfig($conn_key, SqliteConfig::class);
        parent::__construct($cfg);
    }
}
