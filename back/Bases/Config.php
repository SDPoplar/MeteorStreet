<?php
namespace Mxs\Bases;

use \Mxs\Exceptions\DevelopExceptions\{
    MainConfigFileMissing as ErrMainConfigFileMissing,
    ConfigGroupNotFound as ErrConfigGroupNotFound,
};

class Config
{
    public function __construct(string $configPath)
    {
        $this->cfgPath = $configPath;
        $sys_cfg_file = $configPath.'/app.php';
        file_exists($sys_cfg_file) or ErrMainConfigFileMissing::throm($sys_cfg_file);
        $this->sysItems = include($sys_cfg_file);
    }

    public function isDebug() : bool {
        return $this->sys( 'app_debug', false );
    }

    public function sys(string $cfgKey, $def = null)
    {
        return $this->sysItems[$cfgKey] ?? $def;
    }

    public function __call(string $method, $args)
    {
        if (!array_key_exists($method, $this->items)) {
            $cfgPath = $this->cfgPath.'/'.$method.'.php';
            if (file_exists($cfgPath)) {
                $this->items[$method] = include($cfgPath);
            } else {
                ErrConfigGroupNotFound::throm($cfgPath);
            }
        }
        $all = $this->items[$method];
        $def = $args[ 1 ] ?? null;
        $parts = explode('.', $args[ 0 ]);
        while (!empty($parts)) {
            $all = $all[array_shift($parts)] ?? $def;
        }
        return $all;
    }

    protected function parseFile( string $fileName ) : bool {
        $fileContent = include( $fileName );
        if( !is_array( $fileContent ) ) {
            return false;
        }

        $this->merge( $fileContent );
        return true;
    }

    protected string $cfgPath;
    protected array $sysItems;
    protected array $items = [];
}

