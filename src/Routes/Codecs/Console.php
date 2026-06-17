<?php
namespace Mxs\Routes\Codecs;

use Mxs\Routes\Action;
use Override;

class Console implements CodecInterface
{
    #[Override]
    public function buildCacheContent(array $rules): array
    {
        //  TODO:
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
        $inner_cmd = self::buildInnerCmdMap();
        $routeParams = [];
        return $inner_cmd[$path] ?? null;
    }

    public static function buildInnerCmdMap(): array
    {
        return [
            'help' => new Action(\Mxs\Commands\Helper::class, 'usage', describe: 'This usage'),
            'cache:route' => new Action(\Mxs\Commands\Cache::class, 'route', describe: 'Build route cache'),
        ];
    }
}