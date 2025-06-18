<?php
namespace Mxs\Modes;

readonly class Console extends \Mxs\Frame\AppMode
{
    public function __construct(
        string $root_input_type = \Mxs\Inputs\Console::class,
        string|\Mxs\Frame\Render $use_render = \Mxs\Console\Render::class,
    ) {
        parent::__construct($root_input_type, ['command'], $use_render);
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

