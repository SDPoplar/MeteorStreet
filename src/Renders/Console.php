<?php
namespace Mxs\Renders;

use Override;

class Console implements \Mxs\Gate\Render
{
    #[Override]
    public function onSuccess(mixed $response): void
    {
        echo match(true) {
            is_string($response) or $response instanceof \Stringable => $response,
            default => print_r($response, true),
        }, PHP_EOL;
    }

    #[Override]
    public function onException(\Throwable $e): bool
    {
        $msg = $e->getMessage();
        if ($e instanceof \Mxs\Exceptions\Develops\MxsDevelop) {
            $msg .= (PHP_EOL . $e->proposal);
        }
        fputs(STDERR, $msg . PHP_EOL);
        return true;
    }
}
