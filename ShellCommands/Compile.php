<?php
namespace Mxs\ShellCommands;

class Compile extends \Mxs\Abstracts\ShellCommand
{
    public static function getCommandFlag() : string
    {
        return 'compile';
    }

    public static function getCommandDescribe() : string
    {
        return 'compile somethine like route or config, to make app run faster';
    }

    public function execute(array $shell_inputs, \Mxs\Bases\Process\Base $process) : void
    {
        $method = match(array_shift($shell_inputs)) {
            'route' => 'compileRoute',
            null => 'invalidParams',
        };
        $this->$method();
    }

    protected function compileRoute()
    {
        $routeMgr = \Mxs\Core::get()->route;
    }
}

