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
    protected const string ROUTE_EQUAL_KEY = '/';
    protected const string ROUTE_PATTERN_KEY = '//';
    protected const string CACHED_KEY_COLUMN = 'keys';
    protected const string CACHED_MAP_COLUMN = 'map';

    public function __construct() {
        $this->cache_path = \Mxs\App::get()->storage->routeCachePath(create_ifnot_exists: app()->debug);
    }

    public function cache(): void
    {
        $route_path = \Mxs\App::get()->app_root->merge('Route', 'registers');
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
            $keyMap = [];
            foreach(Route::getRulesByMethod($method) as $index => $rule) {
                $item = $this->routeKeyExplode($rule->path, $index);
                $all_keys[] = $item->parts;
                $keyMap[$index] = ['ins' => serialize($rule->buildAction()), 'route' => $item->columns];
            }
            $cache_content = [
                self::CACHED_KEY_COLUMN => array_merge_recursive(...$all_keys ?? []),
                self::CACHED_MAP_COLUMN => $keyMap
            ];
            $save_to_file = $this->cache_path->merge("{$method}.php");
            \SeaDrip\Tools\ArrayExt::toFile($cache_content, $save_to_file)
                or throw new ErrCacheRouteFailed($save_to_file);
            unset($all_keys);
        }
    }

    public function dispatch(\Mxs\Inputs\RootInput &$in): \Mxs\Routes\Action
    {
        $method = $in->route_method;
        $path = $in->route;
        $cached = $this->cache_path->merge("{$method}.php");
        file_exists($cached) or throw new ErrRouteNotFound($method, $path);
        is_readable($cached) or throw new ErrCannotReadFile($cached);
        $cached_content = include($cached);
        $found = $this->routeMatch($path, $cached_content[self::CACHED_KEY_COLUMN]);
        is_null($found) and throw new ErrRouteNotFound($method, $path);
        $cached_item = $cached_content[self::CACHED_MAP_COLUMN][$found->routeKey] ?? null;
        $act = (fn(string $s): \Mxs\Routes\Action => unserialize($s, ['allowed_classes' => [
            \Mxs\Routes\Action::class
        ]]))($cached_item['ins']);
        $in->setRouteParams(array_combine(array_reverse($cached_item['route']), $found->params));
        return $act;
    }

    final protected function routeMatch(string $queryString, array $keys): ?object
    {
        $parts = explode('/', $queryString);
        if (str_starts_with($queryString, '/')) {
            array_shift($parts);
        }
        $routeParams = [];
        while($item = array_shift($parts)) {
            $use_pattern = !array_key_exists($item, $keys);
            if ($use_pattern && !array_key_exists(self::ROUTE_PATTERN_KEY, $keys)) {
                return null;
            }
            if ($use_pattern) {
                $routeParams[] = $item;
                $keys = $keys[self::ROUTE_PATTERN_KEY];
            } else {
                $keys = $keys[$item];
            }
        }
        $found = is_string($keys[self::ROUTE_EQUAL_KEY] ?? null);
        return $found ? new readonly class ($keys[self::ROUTE_EQUAL_KEY], $routeParams) {
            public function __construct(
                public string $routeKey,
                public array $params,
            ) {}
        } : null;
    }

    final protected function routeKeyExplode(string $rule, string $use_index): object
    {
        $parts = explode('/', trim($rule));
        if (!empty($parts) && empty(end($parts))) {
            array_pop($parts);
        }
        $ret = [self::ROUTE_EQUAL_KEY => $use_index];
        while($item = array_pop($parts)) {
            if (str_starts_with($item, '{') && str_ends_with($item, '}')) {
                $use_key = self::ROUTE_PATTERN_KEY;
                $rp[] = trim($item, "{}");
            } else {
                $use_key = $item;
            }
            $ret = [$use_key => $ret];
        }
        return new readonly class ($ret, $rp ?? []) {
            public function __construct(
                public array $parts,
                public array $columns,
            ) {}
        };
    }

    protected readonly \SeaDrip\Tools\Path $cache_path;
}
