<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class StorageManager
{
    protected function __construct(
        public readonly Path $storage_root
    ) {
        $storage_root->create();
    }

    public function logPath(bool $create_ifnot_exists = false): Path
    {
        return $this->getPath('log', $create_ifnot_exists);
    }

    public function cachePath(bool $create_ifnot_exists = false): Path
    {
        return $this->getPath('cache', $create_ifnot_exists);
    }

    protected function getPath(string $path, bool $create_ifnot_exists = false): Path
    {
        $ret = $this->storage_root->merge($path);
        if ($create_ifnot_exists) {
            $ret->create() or throw new \Mxs\Exceptions\Runtimes\CreatePathFailed($path);
        }
        return $ret;
    }
}
