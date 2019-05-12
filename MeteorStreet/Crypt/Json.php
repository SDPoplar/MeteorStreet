<?php
namespace Mxs\Crypt;

class Json {
    public function decrypt( \Mxs\Base\Request &$request ) {
        $items = json_decode( $request->getContent, true );
        foreach( $items as $key => $item ) {
            if( !$request->itemExists( $key ) ) {
                $request->setItem( $key, $item );
            }
        }
    }

    public function encrypt( \Mxs\Base\Response &$response ) {
        $response->setContents( json_encode( $response->getContents() ) );
    }

}

