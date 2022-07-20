<?php
namespace Mxs\Channels;

class Database extends \Mxs\Abstracts\Channel
{
    public function get( DatabaseBasis $basis = null, int $getMode = 0 ) : array {
        $db = \Mxs\Tools\Databases\PdoManager::GetInstance()->getConnection(
            $this->getDatabaseConnectionKey( true, $basis )
        );
        return $db->query( $basis );
    }

    public function set( DatabaseBasis $basis = null, int $setMode = 0 ) : int {
        return [];
    }

    protected function getDatabaseConnectionKey( bool $isGet, DatabaseBasis $basis ) : string {
        return 'default';
    }

    abstract protected function getModelClass() : string;
}

