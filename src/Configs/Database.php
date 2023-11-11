<?php
namespace Mxs\Configs;

use \Mxs\Exceptions\Develops\UnknownDatabaseConnection as UDCE;

class Database
{
    public function setDefault(string $label): self
    {
        $this->def_conn_label = $label;
        return $this;
    }

    public function &appendConnection(string $label, Pdo\PdoConfig $conn_config): self
    {
        $this->conn[$label] = $conn_config;
        return $this;
    }

    public function connection(string $label = ''): Pdo\PdoConfig
    {
        if (empty($label)) {
            $label = $this->def_conn_label;
        }
        array_key_exists($label, $this->conn) or throw new UDCE($label, array_keys($this->conn));
        return $this->conn[$label];
    }
    
    private string $def_conn_label = '';
    private array $conn = [];
}
