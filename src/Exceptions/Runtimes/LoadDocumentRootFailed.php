<?php
namespace Mxs\Exceptions\Runtimes;

class LoadDocumentRootFailed extends MxsRuntime
{
    public function __construct()
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::LoadDocumentRootFailed,
        );
        $this->appendContext($_SERVER);
    }
}
