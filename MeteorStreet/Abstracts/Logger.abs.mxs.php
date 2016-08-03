<?php
namespace MxsClass\Abstracts;

abstract class LoggerAbs extends SingleAbs {
    abstract public function write( $content, $level = LOG_LEVEL_ERROR );
}
