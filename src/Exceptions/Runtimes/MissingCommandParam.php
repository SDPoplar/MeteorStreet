<?php
namespace Mxs\Exceptions\Runtimes;

class MissingCommandParam extends MxsRuntime
{
    public function __construct(string ...$missed)
    {
        $miss_num = count($missed);
        $merged = implode(',', $missed);
        parent::__construct(
            \SeaDrip\Http\Status::BadRequest,
            InnerCode::MissingCommandParam->value,
            ($miss_num > 1) ? "params {$merged} are required" : "param {$merged} is required"
        );
    }
}