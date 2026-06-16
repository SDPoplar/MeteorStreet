<?php
namespace Mxs\Commands;

use Override;

class Help extends BaseCommand
{
    #[Override]
    public static function getCommandFlag(): string
    {
        return 'help';
    }

    #[Override]
    public static function getCommandDescribe(): string
    {
        return 'show this usage';
    }

    public function execute(\Mxs\Inputs\Console $input)
    {
        $usage = <<<usagestr
usage: php mxs [group:]command [params]
registed commands:
usagestr;

        echo $usage, PHP_EOL;
        foreach (\Mxs\Console\Dispatcher::getCommandList() as $line) {
            list('key' => $flag, 'describe' => $describe) = $line;
            printf("    %-20s%s\n", $flag, $describe);
        }
    }
}

