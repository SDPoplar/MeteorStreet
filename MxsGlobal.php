<?php
function GetMxs() : \Mxs\Bases\Core {
    return \Mxs\Bases\Core::GetInstance();
}

function GetConfig( string $key, $defVal = null ) {
    return GetMxs()->getConfig()->getItem( $key, $defVal );
}

