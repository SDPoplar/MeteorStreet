<?php
namespace Mxs\Abstracts;

abstract class Compileable
{
    public function __construct(string $origin_path, string $compiled_path)
    {
        
    }

    public readonly string $origin_path;
    public readonly string $compiled_path;
}

