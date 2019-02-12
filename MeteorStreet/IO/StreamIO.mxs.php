<?php
namespace Mxs\IO;

class StreamIO {
    public function input() {
        return file_get_contents( 'php://input' );
    }

    public function output( \Mxs\Base\Response $response ) {
        echo $response->getContent();
    }
}

