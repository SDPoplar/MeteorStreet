<?php
namespace Mxs\Processes;

class Console extends Base
{
    public function run() : void
    {
        $shell_line = $_SERVER['argv'] ?? $argv ?? [];
        array_shift($shell_line);
        $cmd = array_shift($shell_line);
        $cmdIns = self::findCommandByFlag($cmd ?: 'help');
        $cmdIns->execute($shell_line, $this);
        die(print_r($_SERVER['argv'], true));
    }

    protected static function findCommandByFlag(string $flag) : ?\Mxs\Abstracts\ShellCommand
    {
        $cmdType = self::getCommandList()[$flag] ?? null;
        return $cmdType ? new $cmdType() : null;
    }

    final public static function getCommandList() : array
    {
        return array_merge(self::getCustomCommands(), self::getInnerCommands());
    }

    protected static function getInnerCommands() : array
    {
        return [
            'help' => \Mxs\ShellCommands\Help::class,
            'compile' => \Mxs\ShellCommands\Compile::class
        ];
    }

    protected static function getCustomCommands() : array
    {
        return [];
    }
}

