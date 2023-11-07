<?php
namespace Mxs\Commands;

use \Mxs\Inputs\Console as ConsoleInput;
use \Mxs\Inputs\RootInputInterface;
use \Mxs\Route\Item;

class Router implements \Mxs\Route\Router
{
    public function despatch(RootInputInterface $in): Item
    {
        $real_in = (fn($given): ConsoleInput => $given)($in);
        throw new \Mxs\Exceptions\Develops\CommandNotFound('hello');
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
