<?php
namespace Mxs\Inputs;

interface RootInputInterface
{
    public function input(string $column, $def_val = null);
}
