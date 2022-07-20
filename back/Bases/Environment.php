<?php
namespace Mxs\Bases;

class Environment
{
    public function __construct(string $app_root, string $mxs_root)
    {
        $this->app_root = $app_root;
        $this->mxs_root = $mxs_root;
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
        return $this->_mxs_root.'/Resources';
    }

    protected $app_root;
    protected $mxs_root;
}

