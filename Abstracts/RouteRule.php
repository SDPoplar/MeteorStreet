<?php
namespace Mxs\Abstracts;

abstract class RouteRule
{
    abstract public function execute( \Mxs\Bases\Request $request, \Mxs\Bases\Response &$response );

    public function __construct( string $match ) {
        $this->_use_regex = preg_match( '/\{\w+\}/', $match );
        $this->_matched_url = $this->_use_regex ? $this->loadPregMap( $match ) : $match;
    }

    public function matched( \Mxs\Bases\Request $request ) : bool {
        return $this->_use_regex
            ? $this->pregUrl( $request->getUrl() )
            : ( $request->getUrl() == $this->_matched_url );
    }

    protected function getUrlArgs() : array {
        return $this->_url_args;
    }

    protected function loadPregMap( string $origin ) : string {
        preg_match_all( '/\{(\w+)\}/', $origin, $matches );
        $this->_preg_map = $matches[ 1 ] ?? [];
        return str_replace( '/', '\/', preg_replace( '/\{\w+\}/', '([^/]+)', $origin ) );
    }

    protected function pregUrl( string $url ) : bool {
        $regex = '/'.$this->_matched_url.'/';
        if( !preg_match_all( $regex, $url, $matches ) ) {
            return false;
        }

        array_shift( $matches );
        foreach( $matches as $key => $val ) {
            $this->_url_args[ $this->_preg_map[ $key ] ] = $val[ 0 ];
        }
        return true;
    }

    protected $_matched_url;
    protected $_use_regex;
    protected $_url_args = [];
    protected $_preg_map = [];
}

