<?php
namespace Mxs\Routes;

class Manager
{
    public function __construct(string $routePath, string $cachePath)
    {
        $this->route_path = $routePath;
        $this->cache_path = $cachePath;
    }

    public function findRoute(string $method, string $url) : ?array
    {
        $cache = $this->getCache($method);
        if (empty($cache)) {
            return null;
        }

        if (array_key_exists($url, $cache['eq'])) {
            return $cache['eq'][$url];
        }

        foreach ($cache['match'] as $pattern => $line) {
            if (preg_match("/^{$pattern}$/", $url, $matches)) {
                return array_merge($line, ['url_params' => $matches ?? []]);
            }
        }

        return $cache['def'] ?? null;
    }

    public function getCache(string $method) : array
    {
        $file_path = $this->cache_path.'/'.$method.'.php';
        return file_exists($file_path) ? include($file_path) : [];
    }

    public function cacheAll() : int
    {
        $sum = 0;
        $all = [];
        foreach (scandir($this->route_path) as $item) {
            if (in_array($item, ['.', '..']) || (strtolower(substr($item, -4)) != '.php')) {
                continue;
            }
            $all = array_merge_recursive($all, $this->parseRouteFile( $this->route_path.'/'.$item));
            $sum++;
        }
        foreach ($all as $method => $rules) {
            $cache_file = "{$this->cache_path}/{$method}.php";
            $tpl =<<<cachetpl
<?php
return [
    "eq" => [__EQ_PARTS__],
    "match" => [__MATCH_PATHS__],
    "def" => __DEF__,
];
cachetpl;
            $matches = [];
            $eq = [];
            foreach ($rules as $line) {
                if ($line->isDefRoute()) {
                    $def = $line;
                    continue;
                }
                if ($line->patternRule()) {
                    $matches[] = "".$line;
                } else {
                    $eq[] = "".$line;
                }
            }
            $tpl = str_replace('__DEF__', $def ?? 'null', $tpl);
            $tpl = str_replace('__EQ_PARTS__', implode(',', $eq), $tpl);
            $tpl = str_replace('__MATCH_PATHS__', implode(',', $matches), $tpl);
            file_put_contents($cache_file, $tpl);
        }
        return $sum;
    }

    protected function parseRouteFile(string $filePath) : array
    {
        $action = function($route) use ($filePath) {
            include($filePath);
            return $route->getAll();
        };
        return $action(new \Mxs\Route\RuleManager());
    }

    protected string $route_path;
    protected string $cache_path;
}

