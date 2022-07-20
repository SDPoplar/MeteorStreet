<?php
namespace Mxs\Components;

use \SeaDrip\Tools\Path;

class FileStructure
{
    public function __construct(string $doucment_root)
    {
        $this->document_root = $doucment_root;
    }

    public function getConfigDir(): Path
    {
        return $this->getDir('config');
    }

    public function getLogDir(): Path
    {
        return $this->getDir('storage/log');
    }

    public function getDir(string $path, bool $create_ifnot_exists = false): Path
    {
        $pi = new Path($this->document_root, $path);
        if ($create_ifnot_exists && !$pi->exists()) {
            $pi->create() or (new \Mxs\Exceptions\Runtimes\CreatePathFailed($pi))->occur();
        }
        return $pi;
    }

    public function getFilePath(string $path): string
    {
        if (!str_starts_with('/', $path)) {
            $path = ('/'.$path);
        }
        return $this->doucment_root.$path;
    }

    public readonly string $document_root;
}
