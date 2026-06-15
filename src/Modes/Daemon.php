<?php
namespace Mxs\Modes;

use Override;

readonly class Daemon extends \Mxs\Modes\Console
{
    #[Override]
    public function run(bool $debug): void
    {
        set_time_limit(0);
        throw new \Exception('Not implemented');
    }
}