<?php
namespace Mxs\Console\Commands;

class Help extends \Mxs\Console\Command
{
    public static function getCommandFlag(): string
    {
        return 'help';
    }

    public static function getCommandDescribe(): string
    {
        return 'show this usage';
    }

    public function execute(\Mxs\Inputs\RootInputInterface $input)
    {
        $usage = <<<usagestr
usage: php mxs command [params]
registed commands:
usagestr;

        echo $usage, PHP_EOL;
        foreach (\Mxs\Console\Dispatcher::getCommandList() as $line) {
            list('key' => $flag, 'describe' => $describe) = $line;
            printf("    %-20s%s\n", $flag, $describe);
        }
    }
}

