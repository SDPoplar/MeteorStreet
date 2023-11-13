<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class Environment
{
    public function __construct(Path $app_root)
    {
        (\Dotenv\Dotenv::createImmutable(''.$app_root))->safeLoad();
    }

    //  ========================== env vals   ===========================================
    public function get(string $column, $def_val = null)
    {
        return $_ENV[$column] ?? $def_val;
    }

    public function getBool(string $column, bool $def_val = false): bool
    {
        return boolval($this->get($column, $def_val));
    }

    public function getInt(string $column, int $def_val = 0): int
    {
        return intval($this->get($column, $def_val));
    }

    public function getString(string $column, string $def_val = ''): string
    {
        return ''.$this->get($column, $def_val);
    }
}

