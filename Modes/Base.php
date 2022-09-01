<?php
namespace Mxs\Modes;

abstract class Base
{
    const RESPONSE_FORMATTER = \Mxs\Http\Renders\Json::class;

    abstract public function process(): void;
}
