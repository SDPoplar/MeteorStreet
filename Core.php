<?php
namespace Mxs;

class Core extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {}

    final public function run(string $process = \Mxs\Modes\Http::class) : void
    {
        $process_instance = new $process();
        $this->takeOverExceptions($process_instance::RESPONSE_FORMATTER);
        $process_instance->process();
    }

    private function takeOverExceptions(string $formatter_class): void
    {
        $handler = function(\Error|\Exception $e) use ($formatter_class) {
            $formatter_class::error($e);
            return true;
        };
        set_exception_handler($handler);
        set_error_handler(function($e) use ($formatter_class) {
            var_dump($e);
            return true;
        });
    }
}

