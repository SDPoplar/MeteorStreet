<?php
namespace Mxs\Routes\Codecs;

use Mxs\Routes\Action;
use Override;

class Http implements CodecInterface
{
    protected const string ROUTE_EQUAL_KEY = '/';
    protected const string ROUTE_PATTERN_KEY = '//';
    protected const string CACHED_KEY_COLUMN = 'keys';
    protected const string CACHED_MAP_COLUMN = 'map';

    #[Override]
    public function buildCacheContent(array $rules): array
    {
        $keyMap = [];
        foreach($rules as $index => $rule) {
            $rule->checkMiddleware();
            $item = $this->routeKeyExplode($rule->path, $index);
            $all_keys[] = $item->parts;
            $keyMap[$index] = ['ins' => serialize($rule->buildAction()), 'route' => $item->columns];
        }
        return [
            self::CACHED_KEY_COLUMN => array_merge_recursive(...$all_keys ?? []),
            self::CACHED_MAP_COLUMN => $keyMap
        ];
    }

    #[Override]
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?Action
    {
        $keys = $cached[self::CACHED_KEY_COLUMN];
        $clearedQs = explode('?', $path);
        $parts = explode('/', $clearedQs[0]);
        if (str_starts_with($path, '/')) {
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
        if (!is_string($keys[self::ROUTE_EQUAL_KEY] ?? null)) {
            return null;
        }
        $found = new readonly class ($keys[self::ROUTE_EQUAL_KEY], $routeParams) {
            public function __construct(
                public string $routeKey,
                public array $params,
            ) {}
        };
        $cached_item = $cached_content[self::CACHED_MAP_COLUMN][$found->routeKey] ?? null;
        $act = (fn(string $s): \Mxs\Routes\Action => unserialize($s, ['allowed_classes' => [
            \Mxs\Routes\Action::class
        ]]))($cached_item['ins']);
        $routeParams = empty($cached_item['route']) ? [] : array_combine(array_reverse($cached_item['route']), $found->params);
        return $act;
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
}