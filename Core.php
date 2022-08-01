<?php
namespace Mxs;

use Mxs\Frame\{
    FileStructure,
    Config,
    Log,
};

class Core extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {}

    final public function run(string $process = \Mxs\Modes\Http::class) : void
    {
        (new $process())->process();
    }
}

