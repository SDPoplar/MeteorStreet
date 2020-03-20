<?php
namespace Mxs\Tools\Databases;

class Connection
{
    public function __construct( Config $config ) {
        $this->_config = $config;
        $this->_conn_ins = $config->hasOptions()
            ? new \PDO( $config->getDsn(), $config->getUser(), $config->getPassword(), $config->getOptions )
            : new \PDO( $config->getDsn(), $config->getUser(), $config->getPassword() );
        $transName = "\\Mxs\\Tools\\Databases\\Translators\\".$config->getDriverName();
        $this->_translator new $transName();
    }

    public function query( \Mxs\Channels\DatabaseBasis $basis, string $modelClass ) : array {
    }

    protected $_conn_ins;
    protected $_config;
    protected $_translator;
}

