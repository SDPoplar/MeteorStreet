<?php
namespace Mxs\Interfaces;

interface CastChild
{
    protected function afterBeenCasted( $parent ) : ?bool;
}

