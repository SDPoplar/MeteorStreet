<?php
namespace Mxs\Frame\Route;

class Compiled
{
    public static function get(): self
    {
        return self::load('get');
    }

    public static function post(): self
    {
        return self::load('post');
    }

    public static function options(): self
    {
        return self::load('options');
    }

    public function search(string $url): ?Item
    {
        $parts = array_filter(explode('/', trim($url)));
        if (empty($parts)) {
            $from = $this->all_path['*'];
        } else {
            $from = $this->all_path;
            while(!empty($parts)) {
                var_dump($parts);
                $part = array_shift($part);
                var_dump($part);
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
        return $from ? (new Item($from))->withRouteParams($params ?? []) : null;
    }

    protected static function load(string $method): self
    {
        return new self(\Mxs\Frame\FileStructure::get()->getFilePath("storage/compiled/route/{$method}.php"), $method);
    }

    protected function __construct(string $file_path, string $method)
    {
        $this->all_path = is_readable($file_path) ? (include($file_path) ?: []) : [];
        $this->method = $method;
    }

    protected readonly array $all_path;
    public readonly string $method;
}
