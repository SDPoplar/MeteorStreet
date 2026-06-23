<?php
namespace Mxs\Commands;

use Mxs\Inputs\Console;
use Override;

class Help implements \Mxs\Ability\Command
{
    #[Override]
    public static function getUsage(): string
    {
        return 'help';
    }

    #[Override]
    public static function getDescribe(): string
    {
        return 'Show command usages';
    }

    #[Override]
    public function handle(Console $in)
    {
        $usage = <<<usagestr
usage: php mxs [group:]command [params]
registed commands:
  inner commands:
usagestr;

        echo $usage, PHP_EOL;
        foreach (\Mxs\Routes\ConsoleRouter::buildInnerCmdMap() as $cmd) {
            self::printLine($cmd);
        }

        /*
        echo '  routed commands:' . PHP_EOL;
        foreach ( as $cmd) {
            self::printLine($cmd);
        }
        */
    }

    private static function printLine(string $cmd)
    {
        printf("    %-20s%s\n", $cmd::getUsage(), $cmd::getDescribe());
    }
}

