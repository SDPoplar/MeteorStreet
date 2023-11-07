<?php
namespace Mxs\Inputs;

class Console implements RootInputInterface
{
    public function __construct()
    {
        var_dump($_SERVER); exit;
        $this->command = '';
    }

    public function input(string $column, $def_val = null)
    {
        return '';
    }

    public readonly string $command;
}
