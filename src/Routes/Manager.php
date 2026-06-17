<?php
namespace Mxs\Routes;

use Mxs\Exceptions\Runtimes\{
    RouteNotFound as ErrRouteNotFound,
    CannotReadFile as ErrCannotReadFile,
    CreatePathFailed as ErrCreatePathFailed,
    CacheRouteFailed as ErrCacheRouteFailed,
};

class Manager
{
    public function __construct() {
        $this->cache_path = \Mxs\App::get()->storage->routeCachePath(create_ifnot_exists: app()->debug);
    }

    public function cache(): void
    {
        $route_path = \Mxs\App::get()->app_root->merge('route');
        $route_path->exists() or $route_path->create() or throw new ErrCreatePathFailed($route_path);
        $route_path->isReadable() or throw new ErrCannotReadFile($route_path);
        $this->cache_path->exists() or $this->cache_path->create() or throw new ErrCreatePathFailed($this->cache_path);
        foreach(scandir($route_path) as $f) {
            if (!str_ends_with($f, '.php')) {
                continue;
            }
            (function() use ($f, $route_path) {
                $full_path = $route_path->merge($f);
                Route::setCurrentFile($full_path);
                require $full_path;
            })();
        }
        foreach (Route::enumMethods() as $method) {
            $codec = $this->getCodecInstance($method);
            $cache_content = $codec->buildCacheContent(Route::getRulesByMethod($method));
            $save_to_file = $this->cache_path->merge("{$method}.php");
            \SeaDrip\Tools\ArrayExt::toFile($cache_content, $save_to_file)
                or throw new ErrCacheRouteFailed($save_to_file);
            unset($all_keys);
        }
    }

    public function dispatch(string $method, string $path, ?array &$routeParams): \Mxs\Routes\Action
    {
        $codec = $this->getCodecInstance($method);
        if (method_exists($codec, 'matchInnerRoute')) {
            $found = $codec->matchInnerRoute($path, $routeParams);
        }
        if (is_null($found ?? null)) {
            $cached = $this->cache_path->merge("{$method}.php");
            file_exists($cached) or throw new ErrRouteNotFound($method, $path);
            is_readable($cached) or throw new ErrCannotReadFile($cached);
            $found = $codec->routeMatch($path, include($cached), $routeParams);
        }
        is_null($found) and throw new ErrRouteNotFound($method, $path);
        if (!empty($routeParams)) {
            $in->setRouteParams($routeParams);
        }
        return $found;
    }

    final protected function getCodecInstance(string $method): Codecs\CodecInterface
    {
        return ($method === \Mxs\Modes\Console::METHOD) ? new Codecs\Console() : new Codecs\Http();
    }

    protected readonly \SeaDrip\Tools\Path $cache_path;
}
