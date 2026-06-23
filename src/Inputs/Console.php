<?php
namespace Mxs\Inputs;

use Override;

class Console extends RootInput
{
    public function __construct()
    {
        $all = $_SERVER['argv'] ?? [];
        if ((strtolower(array_shift($all)) ?? '') !== 'mxs') {
            throw new \Mxs\Exceptions\Runtimes\ConsoleOnly();
        }
        $command = array_shift($all) ?? 'help';
        parent::__construct($command);
        $this->all_in = $all;
    }

    #[Override]
    public function getMethod(): string
    {
        return \Mxs\Modes\Console::METHOD;
    }

    #[Override]
    public function input(string $column, mixed $def_val = null, string $note = ''): mixed
    {
        if (!array_key_exists($column, $this->all_in)) {
            echo $column . (empty($note) ? '' : "({$note})") . ':' . PHP_EOL;
            $this->all_in[$column] = trim(fgets(STDIN));
        }
        return parent::input($column, $def_val);
    }
}
