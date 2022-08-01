<?php
namespace Mxs\Exceptions\Runtimes;

class LoadDocumentRootFailed extends \RuntimeException
{
    use \Mxs\Exceptions\OccurTrait;

    public function __construct()
    {
        parent::__construct('Load document_root failed, here is the $_SERVER: '.print_r($_SERVER, true));
    }
}
