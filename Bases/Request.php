<?php
namespace Mxs\Bases;

use \Mxs\Enums\RequestIncludeInput as RII;

class Request
{
    public static function Create( string $requestClass = Request::class ) : Request {
        return new $requestClass();
    }

    public function cast( string $childClass ) : Request {
        return ( static::class != $childClass ) ? ( new $childClass( $this ) ) : $this;
    }

    public function &merge( array ...$items ) : Request {
        empty( $items ) || $this->_inputs->merge( $items );
        return $this;
    }

    public function input( $itemName, $defValue = null ) {
        return $this->_inputs->getItem( $itemName, $defValue );
    }

    public function isFromShell() : bool {
        return $this->_request_from->_shell_request;
    }

    public function getUrl() : string {
        return $this->_request_from->_request_url;
    }

    public function getHttpMethod() : int {
        return $this->_request_from->_http_method;
    }

    protected function __construct( Request $origin = null ) {
        if( $origin ) {
            $this->_inputs = $origin->_inputs;
            $this->_uploads = $origin->_uploads;
            $this->_request_from = $origin->_request_from;
        } else {
            $this->_inputs = new class { use \Mxs\Traits\KeyValueMapTrait; };
            $this->_inputs->merge( $_GET, $_POST );
            $this->_uploads = array_merge( $this->_uploads, $_FILES ?? [] );
            $this->_request_from = new class {
                public function __construct() {
                    $this->_shell_request = ( ( $_SERVER[ 'argc' ] ?? 0 ) > 0 );
                    if( $this->_shell_request ) {
                        $this->loadShellArgs();
                    } else {
                        $this->loadHttpArgs();
                    }
                    if( empty( $this->_request_url )
                        || ( strpos( '/', $this->_request_url ) !== 0 )
                    ) {
                        $this->_request_url = '/'.$this->_request_url;
                    }
                }

                private function loadShellArgs() {
                    $args = $_SERVER[ 'argv' ];
                    array_shift( $args );
                    $this->_request_url = implode( '/', $args );
                }

                private function loadHttpArgs() {
                    $this->_request_url = $_SERVER[ 'REQUEST_URI' ];
                    $this->_use_https = !!( $_SERVER[ 'HTTPS' ] ?? false );
                    $this->_http_method = \Mxs\Enums\HttpMethod::FromString(
                        $_SERVER[ 'REQUEST_METHOD' ] );
                }

                public $_shell_request = false;
                public $_http_method = 0;
                public $_request_url = '';
                public $_use_https = false;
            };
            $this->init();
        }
    }

    protected function init() : void {
    }

    protected function valid() : bool {
        return true;
    }

    protected function isNummeric( $itemName ) : bool {
        return is_numeric( $this->input( $itemName ) );
    }

    protected function isPhoneNumber( $itemName ) : bool {
        return $this->isMatchRegex( $itemName, '/^1\d{10}$/' );
    }

    protected function isValidString( $itemName, $maxLen, $minLen = 0 ) : bool {
        $item = $this->input( $itemName );
        if( gettype( $item ) != 'string' ) {
            return false;
        }
        $len = mb_strlen( $item );
        return ( $len >= $minLen ) && ( $len <= $maxLen );
    }

    protected function isMatchRegex( $itemName, $regex ) : bool {
        return preg_match( $regex, $this->input( $itemName ) );
    }

    protected $_inputs;
    protected $_uploads = [];
    protected $_request_from;
}

