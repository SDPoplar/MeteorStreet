<?php
namespace Mxs\Configs;

class AppConfig
{
    public function __construct(
        public readonly bool $debug,
    ) {}
}
