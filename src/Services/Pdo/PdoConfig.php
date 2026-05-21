<?php
namespace Mxs\Services\Pdo;

final readonly class PdoConfig
{
    public function __construct(
        public string $dsn,
        public string $user,
        public string $password
    ) {}

    public static function sqlite(string $file, string $password = ''): self
    {
        return new self("sqlite:{$file}", '', $password);
    }

    public static function mysql(
        string $db,
        string $sock = '',
        string $host = 'localhost',
        int $port = 3306,
        string $user = 'root',
        string $password = '',
    ): self {
        /*
        mysql:host=localhost;port=3307;dbname=testdb
        mysql:unix_socket=/tmp/mysql.sock;dbname=testdb
         */
        $conn = "host={$host};port={$port}";
        if (!empty($sock)) {
            $conn = "unix_socket={$sock}";
        }
        return new self("mysql:{$conn};dbname={$db}", $user, $password);
    }

    public static function postgre(
        string $db,
        string $host = 'localhost',
        int $port = 5432,
        string $user = 'root',
        string $password = '',
    ): self {
        return new self("pgsql:host={$host};port={$port};dbname={$db}", $user, $password);
    }
}