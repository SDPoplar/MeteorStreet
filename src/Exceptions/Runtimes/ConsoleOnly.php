<?php
namespace Mxs\Exceptions\Runtimes;

class ConsoleOnly extends MxsRuntime
{
    public function __construct()
    {
        parent::__construct(
            \SeaDrip\Http\Status::MethodNotAllowed,
            InnerCode::ConsoleOnly->value,
            'Command can only from console'
        );
    }
}