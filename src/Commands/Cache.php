<?php
namespace Mxs\Commands;

use Mxs\Inputs\Console;
use Override;

class Cache implements \Mxs\Ability\Command
{
    #[Override]
    public static function getUsage(): string
    {
        return 'cache:route';
    }

    #[Override]
    public static function getDescribe(): string
    {
        return 'check route defines, and then build cache';
    }

    #[Override]
    public function handle(Console $in)
    {
        new \Mxs\Routes\Manager()->cache();
    }
}