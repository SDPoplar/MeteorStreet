<?php
namespace Mxs\Inputs;

use Mxs\Exceptions\Runtimes\{
    ConsoleCancel,
    MissingCommandParam,
};
use Override;

class Console extends RootInput
{
    protected const string CONSOLE_CANCLE = '\\c';

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
            echo $column . (empty($note) ? '' : "({$note})"), ': ';
            $this->all_in[$column] = self::oneStdInput();
        }
        return parent::input($column, $def_val);
    }

    public function inputUntilValid(
        string $column,
        array $valid_map,
        string $def_val = '',
        string $note = '',
        ?callable $after_input = null
    ): string {
        echo empty($note) ? $column : $note, '(';
        echo implode('/', array_values($valid_map));
        $shorts = [];
        foreach ($valid_map as $short => $full) {
            if (!is_int($short)) {
                $shorts[] = "{$short}={$full}";
            }
        }
        if (!empty($shorts)) {
            echo ', can input ', implode('/', $shorts), ' for short';
        }
        echo ': ';
        do {
            $in = self::oneStdInput();
            if (empty($in)) {
                $in = $def_val;
            }
            if ($in === static::CONSOLE_CANCLE) {
                throw new ConsoleCancel();
            }
            if (!is_null($after_input)) {
                $in = $after_input($in);
            }
            $in = $valid_map[$in] ?? $in;
        } while (!in_array($in, array_values($valid_map)));
        $this->all_in[$column] = $in;
        return $in;
    }

    public function inputMultiLine(string $column, string $end_when, callable $validat): array
    {
        echo "{$column}(one record each line, [{$end_when}] to end):", PHP_EOL;
        do {
            $in = self::oneStdInput();
            if ($in === static::CONSOLE_CANCLE) {
                throw new ConsoleCancel();
            }
            if (($in === $end_when) or !$validat($in)) {
                continue;
            }
            $ret[] = $in;
        } while($in !== $end_when);
        return $ret ?? [];
    }

    public function confirm(string $text): bool
    {
        echo "{$text}, is that sure?(yes/no):";
        do {
            $in = strtolower(self::oneStdInput());
            if ($in === static::CONSOLE_CANCLE) {
                throw new ConsoleCancel();
            }
        } while (($in !== 'yes') and ($in !== 'no'));
        return $in === 'yes';
    }

    private static function oneStdInput(): string
    {
        return trim(fgets(STDIN));
    }
}
