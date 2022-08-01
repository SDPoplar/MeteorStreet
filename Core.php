<?php
namespace Mxs;

use Mxs\Frame\{
    FileStructure,
    Config,
    Log,
};

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
            if (method_exists($e, 'rendor')) {
                die($e->rendor());
            }
            var_dump(gettype($e), $e);
            return true;
        };
        set_exception_handler($handler);
        set_error_handler($handler);
    }
}

