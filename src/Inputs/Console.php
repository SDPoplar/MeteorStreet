<?php
namespace Mxs\Inputs;

use Mxs\Exceptions\Runtimes\MissingCommandParam;
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
        $this->route_params = $all;
    }

    #[Override]
    public function &setRouteParams(array $params): static
    {
        $want_num = count($params);
        $given_num = count($this->route_params);
        if ($want_num > $given_num) {
            $missed = array_slice($params, $given_num);
            throw new MissingCommandParam(... $missed);
        }
        $params = array_combine($params, array_slice($this->route_params, 0, $want_num));
        return parent::setRouteParams($params);
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
