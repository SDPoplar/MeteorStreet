<?php
namespace Mxs\Exceptions\Runtimes;

class Unauthorized extends MxsRuntime
{
    public static function missing(): self
    {
        return new self(InnerCode::MissingAuthorization->value);
    }

    public static function invalid(): self
    {
        return new self(InnerCode::InvalidAuthorization->value);
    }

    public function __construct(int $code)
    {
        parent::__construct(
            \SeaDrip\Http\Status::Unauthorized,
            $code,
        );
    }
}
