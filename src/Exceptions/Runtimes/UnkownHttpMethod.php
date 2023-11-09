<?php
namespace Mxs\Exceptions\Runtimes;

class UnkownHttpMethod extends MxsRuntime
{
    public function __construct(string $method_name)
    {
        parent::__construct(
            \SeaDrip\Http\Status::MethodNotAllowed,
            InnerCode::UnknownHttpMethod,
            "Unkown http method [{$method_name}]",
        );
    }
}
