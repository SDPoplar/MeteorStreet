<?php
namespace Mxs\Console;

use \Mxs\Inputs\Console as ConsoleInput;
use \Mxs\Inputs\RootInputInterface;
use \Mxs\Route\Item;

class Router implements \Mxs\Route\Router
{
    public function dispatch(RootInputInterface $root_input): Item
    {
        $in = (fn($given): ConsoleInput => $given)($root_input);
        $item_type = self::getCommandList()[$in->command] ?? null;   
        empty($item_type) and throw new \Mxs\Exceptions\Develops\CommandNotFound($in->command);
        return new $item_type($in);
    }

    final protected static function findAppCommand(string $command): ?string
    {
        $all = self::getAppCommands();
        return $all[$command] ?? null;
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

    protected static function getInnerCommands(): array
    {
        return [
            \Mxs\Console\Commands\Help::class,
            //  \Mxs\Console\Commands\Compile::class,
        ];
    }

    protected static function getAppCommands(): array
    {
        $kernal_type = \App\Console\Kernal::class;
        return class_exists($kernal_type) ? ($kernal_type::COMMANDS ?? []) : [];
    }
}
