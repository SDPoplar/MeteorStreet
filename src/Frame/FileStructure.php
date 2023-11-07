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

    public function getConfigPath(string $file_name): Path
    {
        return $this->getAppPath('configs/'.$file_name);
    }

    public function getLogPath(): Path
    {
        return $this->getAppPath('storage/log', true);
    }

    public function getCompiledPath(string $path = ''): Path
    {
        $ret = $this->getAppPath('storage/compiled');
        return empty($path) ? $ret : $ret->merge($path);
    }

    public function getAppPath(string $path, bool $create_ifnot_exists = false): Path
    {
        $pi = new Path($this->document_root, $path);
        if ($create_ifnot_exists && !$pi->exists()) {
            $pi->create() or (new \Mxs\Exceptions\Runtimes\CreatePathFailed($pi))->occur();
        }
        return $pi;
    }

    public function getFilePath(string $path): string
    {
        return $this->document_root.DIRECTORY_SEPARATOR.trim($path, DIRECTORY_SEPARATOR);
    }

    public readonly string $document_root;
}
