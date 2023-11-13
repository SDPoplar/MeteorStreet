<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class Environment
{
    public function __construct(Path $app_root, Path $mxs_root)
    {
        $this->app_root = $app_root;
        $this->mxs_root = $mxs_root;
        (\Dotenv\Dotenv::createImmutable(''.$this->app_root))->safeLoad();
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

    // =========================== About Path ===========================================

    final public function root(string $path = '') : string
    {
        /*
        empty( $path ) || $this->_is_ds( substr( $path, -1 ) )
            || ( $path = $path.DIRECTORY_SEPARATOR );
         */
        return $this->app_root.$path;
    }

    final public function langPath() : string
    {
        return $this->root('/lang');
    }

    final public function configPath(string $path = '') : string
    {
        return $this->root('/config'.$path);
    }

    final public function runtimePath(string $path = '') : string
    {
        return $this->root('/runtime'.$path);
    }

    final public function routePath(string $path = '') : string
    {
        return $this->root('/routes'.$path);
    }

    final public function compilePath(string $path = '') : string
    {
        return $this->runtimePath('/compile'.$path);
    }

    public function checkPath(string $path, bool $createIfNotExists = false) : bool
    {
        return is_dir( $path ) || ( $createIfNotExists && mkdir( $path, 0755, true ) );
    }

    public function getMxsResourcePath() : string
    {
        return $this->mxs_root.'/Resources';
    }

    protected $app_root;
    protected $mxs_root;
}

