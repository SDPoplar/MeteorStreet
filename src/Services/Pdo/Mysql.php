<?php
namespace Mxs\Services\Pdo;

abstract class Mysql extends PdoService
{
    protected const string DB_TYPE = 'mysql';

    #[\Override]
    protected static function packColumn(string $column): string
    {
        return "`{$column}`";
    }
}
