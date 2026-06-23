<?php
namespace Mxs\Routes;

use Override;

class ConsoleRouter implements Router
{
    #[Override]
    public function buildCacheContent(array $rules): array
    {
        //  TODO:
        //  var_dump($rules); exit;
        return [];
    }

    #[Override]
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?Action
    {
        if (!array_key_exists($path, $cached)) {
            return null;
        }
        $action = unserialize($cached[$path], ['allowed_classes' => [Action::class]]);
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
}