<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

abstract class CompileManager
{
    public function __construct(
        protected readonly Path $origin_path,
        protected readonly Path $compiled_path,
    ) {}

    abstract public function compile(): bool;
    abstract public function hasCompiled(): bool;
    abstract public function getCompiled(string $flag): mixed;
}
