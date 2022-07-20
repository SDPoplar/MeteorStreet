<?php
namespace Mxs\Modes;

abstract class Base
{
    public function __construct(string $document_root)
    {
        $this->document_root = $document_root;

        $this->loadConfig();
        $this->takeOverExceptions();
    }

    public function run(): void
    {
    }

    private function loadConfig(): void
    {
        $this->config = new \Mxs\Components\Config(
            $this->document_root.'/config',
            $this->document_root.'/runtime/compile/config',
        );
    }

    private function takeOverExceptions(): void
    {
        $handler = function(\Exception $e) {
            if (method_exists($e, 'rendor')) {
                var_dump($e);
                return;
            }
            var_dump(gettype($e), $e);
        };
        set_exception_handler($handler);
        set_error_handler($handler);
    }

    public readonly \Mxs\Components\Config $config;
    public readonly string $document_root;
}
