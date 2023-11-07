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

    final public function run(string|\Mxs\Modes\Base $app_mode = \Mxs\Modes\Http::class) : void
    {
        $this->takeoverExceptions();
        //  $ami = app mode instance
        is_a($app_mode, \Mxs\Modes\Base::class) or throw new \Mxs\Exceptions\Develops\InvalidAppMode($app_mode::class);
        $ami = (fn(): \Mxs\Modes\Base => is_string($app_mode) ? new $app_mode() : $app_mode)();
        $root_input = $ami->initRootInput();
        $route_item = $ami->despatch($root_input);
        $ami->process();
    }

    public function &httpRoutes(): \Mxs\Http\Routes\Manager
    {
        if ($this->route_manager === null) {
            $this->route_manager = new \Mxs\Http\Routes\Manager($this->app_root);
        }
        return $this->route_manager;
    }

    private function takeoverExceptions(): void
    {
        $handler = function($e) {
            var_dump($e);
            //  $formatter_class::error($e);
            return true;
        };
        set_exception_handler($handler);
        set_error_handler($handler);
    }

    public readonly Path $frame_root;
    public readonly Path $app_root;

    public readonly Configs\Manager $config;
    protected ?\Mxs\Http\Routes\Manager $route_manager = null;
}

