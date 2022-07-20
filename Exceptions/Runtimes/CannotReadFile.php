<?php
namespace Mxs\Exceptions\Runtimes;

class CannotReadFile extends \RuntimeException
{
    use \Mxs\Exceptions\OccurTrait;

    public function __construct(string $file_path)
    {
        parent::__construct("Cannot read file: [$file_path]");
    }
}
