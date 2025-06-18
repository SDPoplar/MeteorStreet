<?php
namespace Mxs\Inputs;

readonly class HttpRequest extends RootInput
{
    public function __construct()
    {
        //var_dump($_SERVER, $_ENV); exit;
        parent::__construct($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    function input(string $column, $def_val = null)
    {
        
    }
}
