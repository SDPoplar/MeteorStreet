<?php
namespace Mxs\Abstracts;

abstract class ShellCommand
{
    abstract public static function getCommandFlag() : string;
    abstract public static function getCommandDescribe() : string;
    abstract public function execute(array $shell_inputs, \Mxs\Bases\Process\Base $process) : void;

    protected function invalidParams()
    {
        echo 'Param missing';
    }
}

