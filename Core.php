<?php
namespace Mxs;

use Mxs\Components\{
    FileStructure,
    Config,
    Log,
};

class Core
{
    final public static function &get(): self
    {
        if (self::$ins === null) {
            self::$ins = new self();
        }
        return self::$ins;
    }

    private function __construct()
    {
        $this->file_structure = new FileStructure(
            empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['PWD'] : dirname($_SERVER['DOCUMENT_ROOT'])
        );

        $path = $this->file_structure->getConfigDir();
        $path->exists() or $path->create();
        $this->config = new Config(''.$path);

        $path = $this->file_structure->getLogDir();
        $path->exists() or $path->create();
        $this->log = new Log(''.$path);
        $this->log->info('hello');
        exit();
    }

    final protected function &getEnvironment() : \Mxs\Bases\Environment
    {
        return $this->env;
    }

    final protected function &getConfig() : \Mxs\Components\Config
    {
        return $this->config;
    }

    final public function run(string $process = \Mxs\Modes\Http::class) : void
    {
        (new $process())->run();
    }

    public readonly FileStructure $file_structure;
    private readonly Config $config;
    private static ?self $ins = null;
}

