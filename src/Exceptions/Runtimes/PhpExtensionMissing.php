<?php
namespace Mxs\Exceptions\Runtimes;

class PhpExtensionMissing extends MxsRuntime
{
    public function __construct(string $ext_name)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::PhpExtendMissing->value,
            "php ext {$ext_name} missing",
        );
    }
}