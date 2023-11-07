<?php
namespace Mxs\Commands;

abstract class ShellCommand
{
    abstract public static function getCommandFlag() : string;
    abstract public static function getCommandDescribe() : string;
    abstract public function execute(array $shell_inputs) : void;

    protected function invalidParams(): never
    {
        die('Param missing');
    }
}

