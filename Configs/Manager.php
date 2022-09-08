<?php
namespace Mxs\Configs;

use \SeaDrip\Tools\Path;

class Manager extends \Mxs\Frame\CompileManager
{
    public function __construct(Path $document_root)
    {
        parent::__construct(
            origin_path: $document_root->merge('configs'),
            compiled_path: $document_root->merge('compiled/configs'),
        );
        $this->compiled_path->exists() or $this->compiled_path->create();
        $loaded_app_config = $this->getCompiled('app');
        $this->app = $loaded_app_config ?: new AppConfig(false);
    }

    public function compile(): bool
    {
        return false;
    }

    public function hasCompiled(): bool
    {
        return false;
    }

    public function getCompiled(string $flag): mixed
    {
        return @include($this->compiled_path . '/' . $flag . '.php');
    }

    public readonly AppConfig $app;
}
