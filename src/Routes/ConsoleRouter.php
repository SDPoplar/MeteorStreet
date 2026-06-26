<?php
namespace Mxs\Routes;

use Override;

class ConsoleRouter implements Router
{
    #[Override]
    public function buildCacheContent(array $rules): array
    {
        $ret = [];
        foreach ($rules as $r) {
            $ri = (fn($item): Rule => $item)($r);
            $path_parts = explode(' ', $ri->path);
            $cmd = array_shift($path_parts);
            $ret[$cmd] = [
                'ins' => serialize($ri->buildAction()),
                'route' => array_filter(array_map(function (string $item): ?string {
                    return explode('(', trim(trim($item, '{}')))[0] ?? '';
                }, $path_parts)),
            ];
        }
        return $ret;
    }

    #[Override]
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?Action
    {
        if (!array_key_exists($path, $cached)) {
            return null;
        }
        ['ins' => $actIns, 'route' => $route] = $cached[$path];
        $action = unserialize($actIns, ['allowed_classes' => [Action::class]]);
        $routeParams = $route ?? [];
        return $action instanceof Action ? $action : null;
    }

    public function matchInnerRoute(string $path, ?array &$routeParams): ?Action
    {
        $routeParams = [];
        foreach (self::buildInnerCmdMap() as $cmd) {
            if ($path === $cmd::getUsage()) {
                return new Action($cmd, 'handle', \Mxs\Inputs\Console::class);
            }
        }
        return null;
    }

    public static function buildInnerCmdMap(): array
    {
        return [
            \Mxs\Commands\Help::class,
            \Mxs\Commands\Cache::class,
        ];
    }

    public static function pickClasses(array $cached): array
    {
        return array_filter(array_map(function($ci): ?string {
            $act = unserialize($ci['ins'], ['allowed_classes' => [Action::class]]);
            return $act instanceof Action ? $act->controller_class : null;
        }, $cached));
    }
}