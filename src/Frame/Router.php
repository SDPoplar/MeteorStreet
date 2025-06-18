<?php
namespace Mxs\Frame;

class Router
{
    public function dispatch(string $method, string $path): \Mxs\Routes\Action
    {
        foreach ($this->origin_files as $f) {
            $found = self::findInCompiled($f, $method, $path);
        }
        throw new \Mxs\Exceptions\Runtimes\RouteNotFound($method, $path);
        // return null;
    }

    public function __construct(
        protected readonly array $origin_files,
    ) {}

    protected static function findInCompiled(
        string $origin_file,
        string $method,
        string $path,
    ): ?string {
        $method = strtolower($method);
        $compiled_path = \Mxs\App::get()->storage->routeCachePath("{$origin_file}-{$method}.php");
        if (!$compiled_path->exists()) {
            //  compile $origin_file ?
        }

        return null;
    }
}
