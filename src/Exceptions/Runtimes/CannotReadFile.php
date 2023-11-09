<?php
namespace Mxs\Exceptions\Runtimes;

class CannotReadFile extends MxsRuntime
{
    public function __construct(string $file_path)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::CannotReadFile,
            "Cannot read file: [$file_path]"
        );
    }
}
