<?php
namespace Mxs\Renders;

use Override;

class Console extends \Mxs\Frame\Render
{
    #[Override]
    public function onSuccess(mixed $response): void
    {
        echo match(true) {
            is_string($response) or $response instanceof \Stringable => $response,
            default => print_r($response, true),
        };
    }

    #[Override]
    public function onException(\Throwable $e): bool
    {
        $msg = $e->getMessage();
        if ($e instanceof \Mxs\Exceptions\Develops\MxsDevelop) {
            $msg .= (PHP_EOL . $e->proposal);
        }
        fputs(STDERR, $msg);
        return true;
    }

    #[Override]
    public function onError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $msg = "[{$errno}]{$errstr}" . PHP_EOL . "{$errfile} line {$errline}";
        fputs(STDERR, $msg);
        return true;
    }
}
