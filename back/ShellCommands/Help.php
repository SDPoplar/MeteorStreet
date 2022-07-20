<?php
namespace Mxs\ShellCommands;

class Help extends \Mxs\Abstracts\ShellCommand
{
    public static function getCommandFlag() : string
    {
        return 'help';
    }

    public static function getCommandDescribe() : string
    {
        return 'show this usage';
    }

    public function execute(array $shell_inputs, \Mxs\Bases\Process\Base $process) : void
    {
        foreach ($process::getCommandList() as $flag => $type) {
            echo "{$flag}\t=> ".$type::getCommandDescribe().PHP_EOL;
        }
    }
}

