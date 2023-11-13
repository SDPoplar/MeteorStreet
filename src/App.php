<?php
namespace Mxs;

use \SeaDrip\Tools\Path;

use \Mxs\Exceptions\Develops\{
    AppNotCreated as ErrAppNotCreated,
    AppAlreadyCreated as ErrAppAlreadyCreated,
    InvalidAppMode as ErrInvalidAppMode,
};

use \Mxs\Exceptions\Runtimes\{
    LoadDocumentRootFailed as LoadDocumentRootFailedException
};

class App
{
    public function __construct(
        string $document_root,
        string|\Mxs\Frame\AppMode $app_mode = \Mxs\Modes\Http::class
    ) {
        is_null(self::$ins) or throw new ErrAppAlreadyCreated();
        self::$ins = $this;

        $dr = new Path($document_root);
        $dr->isReadable() or throw new LoadDocumentRootFailedException();
        $this->app_root = $dr;
        $this->frame_root = new Path(dirname(__FILE__));
        $this->env = new \Mxs\Frame\Environment($this->app_root, $this->frame_root);
        $this->debug = $this->env->getBool('APP_DEBUG');

        is_subclass_of($app_mode, \Mxs\Frame\AppMode::class) or throw new ErrInvalidAppMode(
            is_string($app_mode) ? $app_mode : $app_mode::class
        );
        $this->mode = is_string($app_mode) ? new $app_mode() : $app_mode;
        $this->takeoverExceptions();
    }

    public static function get(): self
    {
        is_null(self::$ins) and throw new ErrAppNotCreated();
        return self::$ins;
    }

    final public function run(
    ): void {
        $root_input = $this->mode->initRootInput();
        $route_item = $this->mode->route($root_input);
        if ($this->mode->canRenderResponse()) {
            $response = $route_item->execute($root_input);
            echo ((fn($ins): \Mxs\Frame\ResponseRenderable => $ins)($this->mode->render))->render($response);
        } else {
            $route_item->execute($root_input);
        }
    }

    private function takeoverExceptions(): void
    {
        $use_mode = $this->mode;
        set_exception_handler(function($e) use ($use_mode) {
            return $use_mode->render->onException($e);
        });
        set_error_handler(function(
            int $errno,
            string $errstr,
            string $errfile,
            int $errline,
            array $errcontext
        ) use ($use_mode): bool {
            return $use_mode->render->onError($errno, $errstr, $errfile, $errline, $errcontext);
        });
    }

    public readonly bool $debug;

    public readonly Path $frame_root;
    public readonly Path $app_root;
    public readonly \Mxs\Frame\Environment $env;

    protected readonly \Mxs\Frame\AppMode $mode;

    private static ?self $ins = null;
}
