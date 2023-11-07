<?php
namespace Mxs\Exceptions\Runtimes;

enum InnerCode:int implements ExceptionCodeInterface
{
    case LoadDocumentRootFailed = 900;
    case RouteNotFound = 901;

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
