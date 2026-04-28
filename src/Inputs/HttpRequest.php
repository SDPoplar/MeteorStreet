<?php
namespace Mxs\Inputs;

class HttpRequest extends RootInput
{
    public function __construct()
    {
        //  var_dump($_SERVER, $_ENV); exit;
        parent::__construct($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $protocal_parts = explode('/', $_SERVER['SERVER_PROTOCOL']);
        $this->protocal = $protocal_parts[0];
        $this->protocal_version = $protocal_parts[1];
    }

    #[\Override]
    function input(string $column, $def_val = null)
    {
        return $_POST[$column] ?? $_GET[$column] ?? $def_val;
    }

    public readonly string $protocal;
    public readonly string $protocal_version;
}
