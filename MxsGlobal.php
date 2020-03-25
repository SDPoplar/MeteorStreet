<?php
function GetMxs() : \Mxs\Bases\Core {
    return \Mxs\Bases\Core::GetInstance();
}

function GetConfig( string $key, $defVal = null ) {
    return GetMxs()->getConfig()->getItem( $key, $defVal );
}

function ThrowError( int $code ) : bool {
    return \Mxs\Exceptions\MxsException::Error( $code );
}

