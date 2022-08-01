<?php
namespace Mxs\Modes;

abstract class Base
{
    const RESPONSE_FORMATTER = 'json';

    abstract public function process(): void;
}
