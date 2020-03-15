<?php
namespace Mxs\Bases;

class Config extends \Mxs\Abstracts\UseAllFiles {
    use \Mxs\Traits\KeyValueMapTrait;

    public function __construct( $configPath ) {
        parent::__construct( $configPath );
    }

    public function isDebug() : bool {
        return $this->getItem( 'app_debug', false );
    }

    protected function parseFile( string $fileName ) : bool {
        $fileContent = include( $fileName );
        if( !is_array( $fileName ) ) {
            return false;
        }

        $this->merge( $fileContent );
        return true;
    }
}

