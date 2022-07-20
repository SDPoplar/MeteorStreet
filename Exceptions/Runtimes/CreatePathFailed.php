<?php
namespace Mxs\Exceptions\Runtimes;

class CreatePathFailed extends \RuntimeException
{
    use \Mxs\Exceptions\OccurTrait;

    public function __construct(string $path)
    {
        parent::__construct("cannot create path [$path]");
    }
}
