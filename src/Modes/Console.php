<?php
namespace Mxs\Modes;

class Console extends Base
{
    public function __construct(
        string $root_input_type = \Mxs\Inputs\Console::class,
        string $route_manager_type = \Mxs\Console\Router::class,
    ) {
        parent::__construct($root_input_type, $route_manager_type);
    }

    public function process(): void
    {
        $shell_line = $_SERVER['argv'] ?? $argv ?? [];
        array_shift($shell_line);
        $cmd = array_shift($shell_line);
        //  $cmdIns = self::findCommandByKey($cmd ?: 'help');
        //  $cmdIns->execute($shell_line);
    }

}

