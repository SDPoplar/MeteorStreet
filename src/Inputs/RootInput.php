<?php
namespace Mxs\Inputs;

use Mxs\Exceptions\Runtimes\InvalidInput;

abstract class RootInput
{
    public function __construct(
        public readonly string $route_method,
        public readonly string $route,
    ) {}

    public function allInputs(): array
    {
        return $this->all_in;
    }
    
    public function input(string $column, mixed $def_val = null): mixed
    {
        return $this->all_in[$column] ?? $def_val;
    }

    public function inputEmail(string $column): string
    {
        $in = $this->input($column);
        is_null($in) and throw new InvalidInput($column);
        $email = filter_var($in, FILTER_VALIDATE_EMAIL);
        ($email === false) and throw new InvalidInput($column, "{$email} isn't a valid email address");
        return $email;
    }

    /**
     * @todo use param $type as phone number check rule mark
     */
    public function inputPhone(string $column,/* string $type = 'zh-cn'*/): string
    {
        $phone = $this->input($column);
        $valid = is_string($phone) and preg_match('/^1\d{10}$/', $phone);
        $valid or throw new InvalidInput($column);
        return $phone;
    }

    public function inputString(string $column, int $minLen = 0, int $maxLen = 0, bool $rquired = false): string
    {
        $s = $this->input($column);
        if ($rquired and is_null($s)) {
            throw new InvalidInput($column);
        }
        $s = $s ?? '';
        $slen = strlen($s);
        if (($minLen > 0) and ($slen < $minLen)) {
            throw new InvalidInput($column, "{$column} should have at least {$minLen} characters");
        }
        if (($maxLen > 0) and ($slen > $maxLen)) {
            throw new InvalidInput($column, "{$column} couldn't be more than {$minLen} characters");
        }
        return $s;
    }

    public function getSortedQuery(): string
    {
        $all = $this->all_in;
        ksort($all);
        return http_build_query($all);
    }

    public function inputPassword(string $column = 'password'): string
    {
        return $this->inputString($column, 1, 72);
    }

    public function route(string $column, mixed $def_val = null)
    {
        return $this->route_params[$column] ?? $def_val;
    }

    public function &setRouteParams(array $params): static
    {
        $this->route_params = $params;
        return $this;
    }

    public function &appendMid(string $name, mixed $value): static
    {
        $this->from_mid[$name] = $value;
        return $this;
    }

    public function mid(string $name, mixed $def = null): mixed
    {
        return $this->from_mid[$name] ?? $def;
    }

    protected array $route_params = [];
    protected array $from_mid = [];
    protected array $all_in;
}
