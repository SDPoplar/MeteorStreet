<?php
namespace Mxs\Exceptions\Runtimes;

class CreatePathFailed extends MxsRuntime
{
    public function __construct(string $path)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::CannotCreatePath,
            "cannot create path [$path]"
        );
    }
}
