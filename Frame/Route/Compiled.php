<?php
namespace Mxs\Frame\Route;

use \SeaDrip\Enums\HttpMethods;

class Compiled
{
    public function search(string $url): Item
    {
        $params = [];
        $from = self::pickItem($this->all_path, array_filter(explode('/', trim($url))), $params);
        $from or (new \Mxs\Exceptions\Runtimes\RouteNotFound($this->method->value, $url))->occur();
        return (new Item(...$from))->withRouteParams($params ?? []);
    }

    public static function load(string|HttpMethods $method): self
    {
        $emethod = is_string($method) ? HttpMethods::tryFrom(strtoupper($method)) : $method;
        $emethod or (new \Mxs\Exceptions\Runtimes\UnkownHttpMethod($method))->occur();
        $all = \Mxs\Frame\FileStructure::get()->getCompiledPath('routes/'.strtolower($emethod->value).'.php');
        return new self($all, $emethod);
    }

    protected function __construct(string $file_path, public readonly HttpMethods $method)
    {
        $this->all_path = is_readable($file_path) ? (include($file_path) ?: []) : [];
    }

    protected static function pickItem(array $all, array $parts, array &$route_params): ?array
    {
        do {
            $search = array_shift($parts);
            if (empty($search)) {
                return $all['index'];
            }
            if (array_key_exists($search, $all['items'])) {
                $all = $all['items'][$search];
            } else {
                $all = $all['patterns'];
                $route_params[] = $search;
            }
        } while (!empty($all));
        return null;
    }

    protected readonly array $all_path;
}
