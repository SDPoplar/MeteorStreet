<?php
namespace Mxs\Services\Pdo;

abstract class Postgre extends PdoService
{
    protected const string DB_TYPE = 'postgre';

    #[\Override]
    protected static function packValue(int|float|string|bool $value): string
    {
        return is_string($value)
            ? '\''.str_replace('\'', '\\\'', $value).'\''
            : parent::packValue($value);
    }
}
