<?php
namespace Mxs\Components;

use \SeaDrip\Tools\Path;

use \Mxs\Exceptions\Runtimes\CannotReadFile as ErrCannotReadFile;

class Config
{
    public function __construct(string $config_path)
    {
        $main_config = new Path($config_path, 'app.php');
        $main_config->isReadable() or (new ErrCannotReadFile($main_config))->occur();
        $this->items = include($main_config);
    }

    public function get(string $key, $default_value = null)
    {
        return $this->items[$key] ?? $default_value;
    }

    protected array $items = [];
}
