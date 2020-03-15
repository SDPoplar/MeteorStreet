<?php
namespace Mxs\Bases;

use \Mxs\Enums\RequestIncludeInput as RII;

class Request
{
    public function __construct() {
        $this->_inputs = new class { use \Mxs\Traits\KeyValueMapTrait; };
    }

    public function &merge( array ...$items ) : Request {
        empty( $items ) || $this->_inputs->merge( $items );
        return $this;
    }

    public function input( $itemName, $defValue = null ) {
        return $this->_inputs->getItem( $itemName, $defValue );
    }

    public function init( int $httpMethod, $inputLimit ) {
        $this->_inputs->merge( $_GET, $_POST );
        $this->_uploads = array_merge( $this->_uploads, $_FILES ?? [] );
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

    protected $_include_input = RII::GET | RII::POST;
    protected $_inputs;
    protected $_uploads = [];
}

