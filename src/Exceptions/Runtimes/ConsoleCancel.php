<?php
namespace Mxs\Exceptions\Runtimes;

class ConsoleCancel extends MxsRuntime
{
    public function __construct()
    {
        parent::__construct(
            \SeaDrip\Http\Status::BadRequest,
            InnerCode::ConsoleCancel->value,
            'Canceled'
        );
    }
}