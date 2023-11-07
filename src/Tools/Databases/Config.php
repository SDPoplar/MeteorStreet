<?php
namespace Mxs\Tools\Databases;

class Config
{
    public function __construct( array $config ) {
        $this->_user = $config[ 'user' ] ?? '';
        $this->_password = $config[ 'password' ] ?? '';
        $this->_driver = strtolower( $config[ 'type' ] ?? 'mysql' );
    }    

    public function getUnique() : string {
        return md5( '' );
    }

    public function getUser() : string {
    }

    public function getPassword() : string {
    }

    public function hasOptions() : bool {
        return !empty( $this->_options );
    }

    public function getDriverName() : string {
    }

    public function getDsn() : string {
        return "";
    }

    public function isPortSetted() : bool {
        return $this->_port !== null;
    }

    public function getPort() : ?int {
        return $this->_port;
    }

    protected $_database;
    protected $_user;
    protected $_password;
    protected $_port = null;
    protected $_options = [];
    protected $_unique;
}

