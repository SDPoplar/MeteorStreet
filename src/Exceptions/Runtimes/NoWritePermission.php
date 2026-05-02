<?php
namespace Mxs\Exceptions\Runtimes;

class NoWritePermission extends MxsRuntime
{
    public function __construct(\SeaDrip\Tools\Path $path)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::NoWritePermission->value,
            "Path {$path} haven't write permission"
        );
    }
}
