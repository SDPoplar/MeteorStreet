<?php
namespace SeaDrip\Mxs\Controller;

class HttpStatus extends \SeaDrip\Mxs\Abstracts\Controller
{
    public function redirect( string $url ) {
        header( 'HTTP/1.1 301 Moved Permanently' );
        header( "Location: {$url}" );
    }

    public function fileNotFound() {
        header( 'HTTP/1.1 404 Not Found' );
        die( 'file not found' );    //  use template file instead in feature
    }
}

