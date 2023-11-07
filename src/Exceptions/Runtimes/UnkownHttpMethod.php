<?php
namespace Mxs\Exceptions\Runtimes;

class UnkownHttpMethod extends MxsRuntime
{
    public function __construct(string $method_name)
    {
        parent::__construct("Unkown http method [{$method_name}]", 400);
    }
}
