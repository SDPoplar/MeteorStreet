<?php
namespace Mxs\Exceptions\Runtimes;

enum InnerCode:int implements ExceptionCodeInterface
{
    case LoadDocumentRootFailed = 900;
    case CannotCreatePath = 901;
    case CannotReadFile = 902;
    case RouteNotFound = 903;
    case UnknownHttpMethod = 904;

    public function exceptionCode(): int
    {
        return $this->value;
    }

    public function message(): string
    {
        return match($this) {
            self::LoadDocumentRootFailed => 'Load document_root failed',
            default => ''
        };
    }
}
