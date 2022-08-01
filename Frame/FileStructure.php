<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class FileStructure extends \SeaDrip\Abstracts\Singleton
{
    protected function __construct()
    {
        $this->document_root = empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['PWD'] : dirname($_SERVER['DOCUMENT_ROOT']);
        empty($this->document_root) and (new \Mxs\Exceptions\Runtimes\LoadDocumentRootFailed())->occur();
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
