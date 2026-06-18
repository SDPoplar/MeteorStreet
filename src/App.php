<?php
namespace Mxs;

use SeaDrip\Tools\Path;

use Mxs\Exceptions\Develops\{
    AppNotCreated as ErrAppNotCreated,
    AppAlreadyCreated as ErrAppAlreadyCreated,
    InvalidAppMode as ErrInvalidAppMode,
    InvalidTimezone as ErrInvalidTimezone,
};

use Mxs\Exceptions\Runtimes\{
    LoadDocumentRootFailed as LoadDocumentRootFailedException,
};

final class App
{
    public function __construct(
        string $document_root,
        string|\Mxs\Frame\AppMode $app_mode = \Mxs\Modes\Http::class
    ) {
        is_null(self::$ins) or throw new ErrAppAlreadyCreated();
        self::$ins = $this;

        $this->app_root = new Path($document_root);
        $this->app_root->isReadable() or throw new LoadDocumentRootFailedException();
        $this->frame_root = new Path(dirname(__FILE__));
        $this->env = new \Mxs\Frame\Environment($this->app_root);
        $this->debug = $this->env->getBool('APP_DEBUG');
        $tz = $this->env->getString('APP_TIMEZONE', 'UTC');
        date_default_timezone_set($tz) or throw new ErrInvalidTimezone($tz);
        $this->timezone = $tz;
        $this->storage = new \Mxs\Frame\StorageManager($this->app_root->merge('storage'));
        $this->config = new \Mxs\Frame\ConfigManager(
            $this->app_root->merge('config'),
            $this->storage->configCachePath(create_ifnot_exists: $this->debug)
        );

        is_subclass_of($app_mode, \Mxs\Frame\AppMode::class) or throw new ErrInvalidAppMode(
            is_string($app_mode) ? $app_mode : $app_mode::class
        );
        $this->mode = is_string($app_mode) ? new $app_mode() : $app_mode;
        $this->takeoverExceptions();

        $this->logger = new \Mxs\Frame\Log($this->storage->logPath(date('Y'), create_ifnot_exists: true));
    }

    public static function get(): self
    {
        is_null(self::$ins) and throw new ErrAppNotCreated();
        return self::$ins;
    }

    final public function run(): void
    {
        $router = new \Mxs\Routes\Manager();
        if ($this->debug) {
            $router->cache();
        }
        $input = $this->mode->getInputInstance();
        $act = $router->dispatch($input->getMethod(), $input->getPath(), $routeParams);
        if (!empty($routeParams)) {
            $input->setRouteParams($routeParams);
        }
        $exec_result = $act->execute($input);
        if (!is_null($exec_result)) {
            $this->mode->output_render->onSuccess($exec_result);
        }
    }

    private function takeoverExceptions(): void
    {
        $use_mode = $this->mode;
        set_exception_handler(function(\Throwable $e) use ($use_mode) {
            $msg = '';
            $context = [];
            if (app()->logger ?? null and $use_mode->log_render->bakeException($e, $msg, $context)) {
                app()->logger->error($msg, $context);
            }
            return $use_mode->output_render->onException($e);
        });
        set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline) use ($use_mode): bool {
            if (!(app()->logger ?? null)) {
                return false;
            }
            app()->logger->error($this->mode->log_render->bakeError($errno, $errstr, $errfile, $errline));
            return $use_mode->output_render->onError($errno, $errstr, $errfile, $errline);
        });
    }

    public readonly bool $debug;
    public readonly string $timezone;

    public readonly Path $frame_root;
    public readonly Path $app_root;
    public readonly \Mxs\Frame\Environment $env;
    public readonly \Mxs\Frame\ConfigManager $config;
    public readonly \Mxs\Frame\StorageManager $storage;
    public readonly \Mxs\Frame\Log $logger;

    protected readonly \Mxs\Frame\AppMode $mode;

    private static ?self $ins = null;
}
