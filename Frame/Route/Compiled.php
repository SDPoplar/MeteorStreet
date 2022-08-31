<?php
namespace Mxs\Frame\Route;

use \SeaDrip\Enums\HttpMethods;

class Compiled
{
    public function search(string $url): Item
    {
        $parts = array_filter(explode('/', trim($url)));
        if (empty($parts)) {
            $from = $this->all_path['*'];
        } else {
            $from = $this->all_path;
            while (!empty($parts)) {
                $part = array_shift($parts);
                if (array_key_exists($part, $from)) {
                    $from = $from[$part];
                    continue;
                }
    
                if (array_key_exists('_pattern', $from)) {
                    $params[] = $part;
                    $from = $from['_pattern'];
                    continue;
                }
                $from = null;
            }
        }
        $from or (new \Mxs\Exceptions\Runtimes\RouteNotFound($this->method->value, $url))->occur();
        return (new Item(...$from))->withRouteParams($params ?? []);
    }

    public static function load(string|HttpMethods $method): self
    {
        $emethod = is_string($method) ? HttpMethods::tryFrom(strtoupper($method)) : $method;
        $emethod or (new \Mxs\Exceptions\Runtimes\UnkownHttpMethod($method))->occur();
        $all = \Mxs\Frame\FileStructure::get()->getCompiledPath('routes'.strtolower($emethod->value).'.php');
        return new self($all, $emethod);
    }

    protected function __construct(string $file_path, public readonly HttpMethods $method)
    {
        $this->all_path = is_readable($file_path) ? (include($file_path) ?: []) : [];
    }

    protected readonly array $all_path;
}
