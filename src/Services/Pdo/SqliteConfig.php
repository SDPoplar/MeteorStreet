<?php
namespace Mxs\Services\Pdo;

use Override;

readonly class SqliteConfig extends PdoConfig
{
    public function __construct(public string $file, string $password = '')
    {
        parent::__construct('', $password);
    }

    #[Override]
    public function getDsn(): string
    {
        return "sqlite:{$this->file}";
    }
}
