<?php
namespace Mxs\Exceptions\Runtimes;

class Unauthorized extends MxsRuntime
{
    public static function missing(): self
    {
        return new self(
            InnerCode::MissingAuthorization->value,
            "Authorization missing"
        );
    }

    public static function invalid(): self
    {
        return new self(
            InnerCode::InvalidAuthorization->value,
            "Invalid authorization"
        );
    }

    public function __construct(int $code, string $message)
    {
        parent::__construct(
            \SeaDrip\Http\Status::Unauthorized,
            $code,
            $message,
        );
    }
}
