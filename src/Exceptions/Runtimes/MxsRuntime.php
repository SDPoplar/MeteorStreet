<?php
namespace Mxs\Exceptions\Runtimes;

abstract class MxsRuntime extends \RuntimeException
{
    use \Mxs\Exceptions\MxsExceptionTrait;

    public function __construct(
        public readonly \SeaDrip\Http\Status $http_status,
        int $exception_code,
        string $message = '',
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $exception_code, $previous);
    }
}
