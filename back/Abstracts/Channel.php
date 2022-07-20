<?php
namespace Mxs\Abstracts;

abstract class Channel
{
    abstract public function get( ChannelBasis $basis = null, int $getMode = 0 );
    abstract public function set( $val, ChannelBasis $basis = null, int $setMode = 0 ) : int;
}

