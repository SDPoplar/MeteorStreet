<?php
namespace Mxs\Channel;

class ArrayFileChannel extends FileChannel {
    protected $_data = [];

    public function __construct( string $fileName, string $spare = '' ) {
        parent::__construct( $fileName );
        if( $this->_canRead() ) {
            $this->_data = include( $this->_fileName );
        } else {
            $this->_valid = false;
        }
    }
    
    public function get( \Mxs\Base\ChannelPattern $pattern = null ) : Array {
        if( !$this->valid() ) {
            return [];
        }

        $key = $pattern ? $pattern->getRuleByName( 'key' ) : null;
        if( $key === null ) {
            return $this->_data;
        }

        $key = is_array( $key ) ? $key : [ $key ];
        return array_intersect_key( $this->_data, array_flip( $key ) );
    }

    public function set( \Mxs\Base\ChannelPattern $pattern, $value, int $lifetime = 0 ) : int{
        if( !$this->_canWrite() ) {
            return 0;
        }

        //  TODO: Write data to file
        return 0;
    }
}

