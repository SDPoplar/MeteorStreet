<?php
namespace Mxs\Services\Pdo;

class PdoService
{
    public function __construct(PdoConfig $cfg)
    {
        try {
            $this->pdo_ins = new \PDO($cfg->getDsn(), $cfg->user, $cfg->password);
        } catch (\PDOException $e) {
            throw new \Mxs\Exceptions\Runtimes\ConnectServiceFailed(previous: $e);
        }
    }

    private \PDO $pdo_ins;
}
