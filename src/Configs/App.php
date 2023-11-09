<?php
namespace Mxs\Configs;

class App
{
    public function __construct(
        public readonly bool $debug = false,
    ) {}

    /*
    protected static function env(string $filed, $dev_val)
    {}
    */
}
