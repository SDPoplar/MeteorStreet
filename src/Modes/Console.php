<?php
namespace Mxs\Modes;

class Console extends Base
{
    public function __construct(
        string $root_input_type = \Mxs\Inputs\Console::class,
        string $route_manager_type
    ) {
        parent::__construct($root_input_type, $route_manager_type);
    }

    public function process(): void
    {
        $shell_line = $_SERVER['argv'] ?? $argv ?? [];
        array_shift($shell_line);
        $cmd = array_shift($shell_line);
        $cmdIns = self::findCommandByKey($cmd ?: 'help');
        $cmdIns->execute($shell_line);
    }

    protected static function findCommandByKey(string $key) : ?\Mxs\Commands\ShellCommand
    {
        $cmdType = self::getCommandList()[$key]['type'] ?? null;
        return $cmdType ? new $cmdType() : null;
    }

    final public static function getCommandList() : array
    {
        $all = array_column(array_map(fn(string $type) => [
            'type' => $type,
            'key' => $type::getCommandFlag(),
            'describe' => $type::getCommandDescribe()
        ], array_merge(self::getAppCommands(), self::getInnerCommands())), null, 'key');
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

    protected static function getAppCommands() : array
    {
        $kernal_type = \App\Commands\Kernal::class;
        return class_exists($kernal_type) ? $kernal_type::COMMANDS : [];
    }
}

