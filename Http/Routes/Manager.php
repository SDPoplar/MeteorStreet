<?php
namespace Mxs\Http\Routes;

class Manager extends \Mxs\Frame\CompileManager
{
    public function __construct(\SeaDrip\Tools\Path $document_root)
    {
        parent::__construct(
            $document_root->merge('routes'),
            $document_root->merge('compiled/routes'),
        );
    }

    public function compile(): bool
    {
        return false;
    }

    public function hasCompiled(): bool
    {
        return false;
    }

    public function getCompiled(string $method): Compiled
    {
        return new Compiled($this->compiled_path, \SeaDrip\Enums\HttpMethods::from($method));
    }
}
