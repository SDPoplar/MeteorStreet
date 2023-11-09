<?php
namespace Mxs;

use \SeaDrip\Tools\Path;

class Core extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {
        $this->frame_root = new Path(dirname(__FILE__));

        $cfg_type = class_exists(\App\Config\App::class) ? \App\Config\App::class : Configs\App::class;
        $this->config = new $cfg_type;
    }

    final public function run(
        string $document_root,
        string|\Mxs\Frame\AppMode $app_mode = \Mxs\Modes\Http::class
    ): void {
        //  $document_root = empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['PWD'] : dirname($_SERVER['DOCUMENT_ROOT']);
        empty($document_root) and (new \Mxs\Exceptions\Runtimes\LoadDocumentRootFailed())->occur();
        $this->app_root = new Path($document_root);

        $this->config = new Configs\Manager($this->app_root);

        $this->takeoverExceptions();
        //  $ami = app mode instance
        is_subclass_of($app_mode, \Mxs\Frame\AppMode::class) or throw new \Mxs\Exceptions\Develops\InvalidAppMode(
            is_string($app_mode) ? $app_mode : $app_mode::class
        );
        $ami = (fn(): \Mxs\Frame\AppMode => is_string($app_mode) ? new $app_mode() : $app_mode)();
        $root_input = $ami->initRootInput();
        $route_item = $ami->route($root_input);
        //  $ami->process();
        $route_item->execute($root_input);
    }

    private function takeoverExceptions(): void
    {
        set_exception_handler(function($e) {
            var_dump($e);
            //  $formatter_class::error($e);
            return true;
        });
        set_error_handler(function(
            int $errno,
            string $errstr,
            string $errfile,
            int $errline,
            array $errcontext
        ): bool {
            return false;
        });
    }

    public readonly Path $frame_root;
    public readonly Path $app_root;

    public readonly Configs\App $config;
    protected ?\Mxs\Http\Routes\Manager $route_manager = null;
}

