<?php
namespace Mxs\Modes;

class Console extends Base
{
    public function process(): void
    {
        $shell_line = $_SERVER['argv'] ?? $argv ?? [];
        array_shift($shell_line);
        $cmd = array_shift($shell_line);
        $cmdIns = self::findCommandByFlag($cmd ?: 'help');
        $cmdIns->execute($shell_line);
    }

    protected static function findCommandByFlag(string $flag) : ?\Mxs\Commands\ShellCommand
    {
        $cmdType = self::getCommandList()[$flag]['type'] ?? null;
        return $cmdType ? new $cmdType() : null;
    }

    final public static function getCommandList() : array
    {
        $all = array_column(array_map(fn(string $type) => [
            'type' => $type,
            'flag' => $type::getCommandFlag(),
            'describe' => $type::getCommandDescribe()
        ], array_merge(self::getCustomCommands(), self::getInnerCommands())), null, 'flag');
        ksort($all);
        return $all;
    }

    protected static function getInnerCommands() : array
    {
        return [
            \Mxs\Commands\Help::class,
            \Mxs\Commands\Compile::class,
        ];
    }

    protected static function getCustomCommands() : array
    {
        $kernal_type = \App\Commands\Kernal::class;
        return class_exists($kernal_type) ? $kernal_type::COMMANDS : [];
    }
}

