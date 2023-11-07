<?php
namespace Mxs\Console\Commands;

class Help extends \Mxs\Console\Command
{
    public static function getCommandFlag() : string
    {
        return 'help';
    }

    public static function getCommandDescribe() : string
    {
        return 'show this usage';
    }

    public function execute()
    {
        $usage = <<<usagestr
usage: php mxs command [params]
registed commands:
usagestr;

        echo $usage, PHP_EOL;
        /*
        foreach (\Mxs\Modes\Console::getCommandList() as $line) {
            list('flag' => $flag, 'describe' => $describe) = $line;
            echo $flag . "\t" . $describe, PHP_EOL;
        }*/
    }
}

