<?php
namespace Mxs\Exceptions\Runtimes;

class InvalidInput extends MxsRuntime
{
    public function __construct(string $column, string $proposal = '', int $err_code = InnerCode::InvalidInput->value)
    {
        parent::__construct(
            \SeaDrip\Http\Status::BadRequest,
            $err_code,
            "Invalid input {$column}".(empty($proposal) ? '' : ", {$proposal}")
        );
    }
}