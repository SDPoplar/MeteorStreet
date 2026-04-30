<?php
namespace Mxs\Exceptions\Develops;

class InvalidConfig extends MxsDevelop
{
    public function __construct(string $config_key, string $want_type)
    {
        parent::__construct(
            "invalid config key {$config_key}",
            "this config should be instance of {$want_type}, please check it"
        );
    }
}