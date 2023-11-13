<?php
namespace Mxs\Console;

abstract class Command implements \Mxs\Route\Item
{
    abstract public static function getCommandFlag(): string;

    abstract public static function getCommandDescribe(): string;

    protected function info(string $content)
    {
        $this->consoleOutput($content);
    }

    protected function error(string $content)
    {
        $this->consoleOutput("\033[31mERROR\033[0m {$content}");
    }

    private function consoleOutput(string $content)
    {
        echo $content, PHP_EOL;
    }
}

