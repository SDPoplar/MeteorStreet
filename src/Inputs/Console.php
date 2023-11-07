<?php
namespace Mxs\Inputs;

class Console implements RootInputInterface
{
    public function __construct()
    {
        $this->command = $_SERVER['argv'][1] ?? 'help';
    }

    public function input(string $column, $def_val = null)
    {
        return '';
    }

    public readonly string $command;
}
