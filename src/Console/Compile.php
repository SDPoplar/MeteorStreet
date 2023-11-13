<?php
namespace Mxs\Console\Commands;

class Compile extends \Mxs\Console\Command
{
    public static function getCommandFlag(): string
    {
        return 'compile';
    }

    public static function getCommandDescribe(): string
    {
        return 'compile something(like route and config), to make app run faster';
    }

    public function execute()
    {
        $method = match(array_shift($shell_inputs)) {
            //'route' => $this->compileRoute(...),
            //'config' => $this->compileConfig(...),
            //null => $this->invalidParams(...),
        };
        $method();
    }

    /*
    protected function compileConfig()
    {
        \Mxs\Core::Get()->config->compile();
        echo 'Done', PHP_EOL;
    }

    protected function compileRoute()
    {
        \Mxs\Core::Get()->httpRoutes()->compile();
        echo 'Done', PHP_EOL;
    }
    */
}

