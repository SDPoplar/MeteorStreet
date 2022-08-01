<?php
namespace Mxs\Modes;

abstract class Base
{
    public function __construct()
    {
        $this->document_root = \Mxs\Frame\FileStructure::Get()->document_root;

        $this->takeOverExceptions();
    }

    public function process(): void
    {}

    private function takeOverExceptions(): void
    {
        $handler = function(\Error|\Exception $e) {
            if (method_exists($e, 'rendor')) {
                var_dump($e);
                return;
            }
            var_dump(gettype($e), $e);
        };
        set_exception_handler($handler);
        set_error_handler($handler);
    }

    public readonly \Mxs\Frame\Config $config;
    public readonly string $document_root;
}
