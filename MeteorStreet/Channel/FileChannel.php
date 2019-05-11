<?php
namespace Mxs\Channel;

class FileChannel extends \Mxs\Abstracts\Channel {
    protected $_fileName = '';
    protected $_valid = true;

    public function __construct( string $fileName, string $spare = '' ) {
        $this->_fileName = file_exists( $fileName ) ? $fileName : $spare;
        $this->_valid = file_exists( $this->_fileName );
    }

    public function valid() : bool {
        return $this->_valid;
    }

    protected function _canRead() : bool {
        return is_readable( $this->_fileName );
    }

    protected function _canWrite() : bool {
        return is_writeable( $this->_fileName );
    }
    
    public function get( \Mxs\Base\ChannelPattern $pattern = null ) : Array {
        return [];
    }

    public function set( \Mxs\Base\ChannelPattern $pattern, $value, int $lifetime = 0 ) : int {
        return 0;
    }
}
