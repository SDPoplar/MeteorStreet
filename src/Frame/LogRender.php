<?php
namespace Mxs\Frame;

use Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use Mxs\Exceptions\Runtimes\MxsRuntime as MxsRuntimeException;
use SeaDrip\Http\Status as HttpStatus;

class LogRender
{
    public function bakeException(\Throwable $e, string &$message, array &$context): bool
    {
        if (($e instanceof MxsRuntimeException) and ($e->http_status !== HttpStatus::InternalServerError)) {
            return false;
        }
        $msg = ($e instanceof MxsDevException) ? $e->getMessage() . PHP_EOL . $e->proposal : $e->getMessage();
        $message = implode(PHP_EOL, [$msg, ... self::traceLines($e->getTrace())]);
        $context = method_exists($e, 'getContext') ? $e->getContext() : [];
        return true;
    }

    public function bakeError(int $errno, string $errstr, string $errfile, int $errline): string
    {
        return "[{$errno}]{$errstr}" . PHP_EOL . "{$errfile} line {$errline}";
    }

    protected static function traceLines(array $trace): array
    {
        return array_map(function($line): string {
            return ($line['class'] ?? '') . ($line['type'] ?? '') . "{$line['function']}({$line['file']} line {$line['line']})";
        }, $trace);
    }
}