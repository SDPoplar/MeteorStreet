<?php
namespace Mxs\Inputs;

readonly class Console extends RootInput
{
    public function __construct()
    {
        parent::__construct('console', $_SERVER['argv'][1] ?? 'help');
    }

    public function input(string $column, $def_val = null)
    {
        return '';
    }
}
