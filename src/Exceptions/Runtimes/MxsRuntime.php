<?php
namespace Mxs\Exceptions\Runtimes;

abstract class MxsRuntime extends \RuntimeException
{
    use \Mxs\Exceptions\MxsExceptionTrait;

    public function __construct(
        public readonly \SeaDrip\Http\Status $http_status,
        ExceptionCodeInterface $exception_code,
        string $message = '',
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            empty($message) ? $exception_code->exceptionCode() : $message,
            $exception_code->exceptionCode(),
            $previous
        );
    }
}
