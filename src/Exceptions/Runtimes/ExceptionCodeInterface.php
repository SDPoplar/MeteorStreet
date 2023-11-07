<?php
namespace Mxs\Exceptions\Runtimes;

interface ExceptionCodeInterface
{
    public function exceptionCode(): int;
    public function message(): string;
}
