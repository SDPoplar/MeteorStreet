<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class StorageManager
{
    public function __construct(
        public readonly Path $storage_root
    ) {
        $storage_root->create();
    }

    public function logPath(string|Path $group = '', bool $create_ifnot_exists = false): Path
    {
        return $this->getPath(new Path('log', $group), $create_ifnot_exists);
    }

    public function routeCachePath(string|Path $group = '', bool $create_ifnot_exists = false): Path
    {
        return $this->cachePath(new Path('route', $group), $create_ifnot_exists);
    }

    public function cachePath(string|Path $group = '', bool $create_ifnot_exists = false): Path
    {
        return $this->getPath(new Path('cache', $group), $create_ifnot_exists);
    }

    protected function getPath(string|Path $path, bool $create_ifnot_exists = false): Path
    {
        $ret = $this->storage_root->merge($path);
        if ($create_ifnot_exists) {
            $ret->create() or throw new \Mxs\Exceptions\Runtimes\CreatePathFailed($path);
        }
        return $ret;
    }
}
