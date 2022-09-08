<?php
namespace Mxs;

use \SeaDrip\Tools\Path;

class Core extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {
        $this->frame_root = new Path(dirname(__FILE__));

        $document_root = empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['PWD'] : dirname($_SERVER['DOCUMENT_ROOT']);
        empty($document_root) and (new \Mxs\Exceptions\Runtimes\LoadDocumentRootFailed())->occur();
        $this->app_root = new Path($document_root);

        $this->config = new Configs\Manager($this->app_root);
    }

    final public function run(string $process = \Mxs\Modes\Http::class) : void
    {
        $process_instance = new $process();
        $this->takeOverExceptions($process_instance::RESPONSE_FORMATTER);
        $process_instance->process();
    }

    public function &httpRoutes(): \Mxs\Http\Routes\Manager
    {
        if ($this->route_manager === null) {
            $this->route_manager = new \Mxs\Http\Routes\Manager($this->app_root);
        }
        return $this->route_manager;
    }

    private function takeOverExceptions(string $formatter_class): void
    {
        $handler = function(\Error|\Exception $e) use ($formatter_class) {
            $formatter_class::error($e);
            return true;
        };
        set_exception_handler($handler);
        /*
        set_error_handler(function($e) use ($formatter_class) {
            var_dump($e);
            return true;
        });*/
    }

    public readonly Path $frame_root;
    public readonly Path $app_root;

    public readonly Configs\Manager $config;
    protected ?\Mxs\Http\Routes\Manager $route_manager = null;
}

