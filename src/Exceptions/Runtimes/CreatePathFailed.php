<?php
namespace Mxs\Exceptions\Runtimes;

class CreatePathFailed extends MxsRuntime
{
    public function __construct(string $path)
    {
        parent::__construct("cannot create path [$path]");
    }
}
