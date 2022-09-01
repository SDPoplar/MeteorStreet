<?php
namespace Mxs\Frame\Responses;

class Http
{
    public function __construct(
        public readonly int $status,
        public readonly \Stringable|string|array $content,
    ){}
}
