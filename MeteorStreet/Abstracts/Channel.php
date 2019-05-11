<?php
namespace Mxs\Abstracts;

abstract class Channel {
    abstract public function get( \Mxs\Base\ChannelPattern $pattern = null ) : Array;

    abstract public function set( \Mxs\Base\ChannelPattern $pattern, $value, int $lifetime = 0 ) : int;
}

