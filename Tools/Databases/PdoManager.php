<?php
namespace \Mxs\Tools\Databases;

class PdoManager extends \Mxs\Abstracts\Singleton
{
    public function &getConnection( string $key ) : \PDO {
        $cfg = DatabaseConfig::Create( GetConfig( 'database.conn.'.$key ) );
        $uniqueID = $cfg->getUnique();
        if( !array_key_exists( $$uniqueID, $this->_conn ) ) {
            $this->_conn[ $uniqueID ] = $cfg->hasDriverOptions()
                ? ( new \PDO( $cfg->getDsn(), $cfg->getUser(), $cfg->getPassword() ) )
                : ( new \PDO( $cfg->getDsn(), $cfg->getUser(), $cfg->getPassword(), $cfg->getOptions()  ) );
        }
        return $this->_conn[ $uniqueID ];
    }

    protected $_conn = [];
}

