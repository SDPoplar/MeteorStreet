<?php
namespace Mxs\Commands;

class Help extends ShellCommand
{
    public static function getCommandFlag() : string
    {
        return 'help';
    }

    public static function getCommandDescribe() : string
    {
        return 'show this usage';
    }

    public function execute(array $shell_inputs) : void
    {
        $usage = <<<usagestr
usage: php mxs command [params]
registed commands:
usagestr;

        echo $usage, PHP_EOL;
        foreach (\Mxs\Modes\Console::getCommandList() as $line) {
            list('flag' => $flag, 'describe' => $describe) = $line;
            echo $flag . "\t" . $describe, PHP_EOL;
        }
    }
}

