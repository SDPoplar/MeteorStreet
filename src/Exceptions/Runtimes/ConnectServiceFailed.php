<?php
namespace Mxs\Exceptions\Runtimes;

class ConnectServiceFailed extends MxsRuntime
{
    public function __construct(string $message = '', ?\Throwable $previous = null)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::ConnectServiceFailed->value,
            $message,
            $previous
        );
    }
}
