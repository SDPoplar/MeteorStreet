<?php
namespace Mxs\Frame;

use \Mxs\Exceptions\Runtimes\CannotReadFile as ErrCannotReadFile;

class Config extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {
        $main_config = FileStructure::Get()->getConfigPath('app.php');
        $main_config->isReadable() or (new ErrCannotReadFile($main_config))->occur();
        $this->app = include($main_config);
    }

    public readonly \Mxs\Configs\AppConfig $app;
}
