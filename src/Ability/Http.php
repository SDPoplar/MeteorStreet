<?php
namespace Mxs\Ability;

use Mxs\Frame\ExecReturn;

abstract class Http
{
    protected function success(?array $data = null): ExecReturn
    {
        return ExecReturn::succ($data);
    }

    protected function redirect(string $target): ExecReturn
    {
        return ExecReturn::redir($target);
    }

    protected function created(array|int $created): ExecReturn
    {
        return ExecReturn::created($created);
    }
}