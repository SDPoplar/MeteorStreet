<?php
namespace Mxs\Exceptions\Runtimes;

class LoadDocumentRootFailed extends MxsRuntime
{
    public function __construct()
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::LoadDocumentRootFailed->value,
            'Load document_root failed'
        );
        $this->appendContext($_SERVER);
    }
}
