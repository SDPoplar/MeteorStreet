<?php
namespace Mxs\Inputs;

class Console extends RootInput
{
    public function __construct()
    {
        parent::__construct('console', $_SERVER['argv'][1] ?? 'help');
        $this->all_in = $_SERVER['argv'] ?? [];
    }

    #[\Override]
    public function input(string $column, mixed $def_val = null): mixed
    {
        if (!array_key_exists($column, $this->all_in)) {
            echo "{$column}:".PHP_EOL;
            $this->all_in[$column] = trim(fgets(STDIN));
        }
        return parent::input($column, $def_val);
    }
}
