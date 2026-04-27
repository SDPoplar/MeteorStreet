<?php
namespace Mxs\Exceptions\Runtimes;

class CacheRouteFailed extends MxsRuntime
{
    public function __construct(string $failed_file)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::CannotCreatePath,
            "Saving cache to {$failed_file} failed"
        );
    }
}
