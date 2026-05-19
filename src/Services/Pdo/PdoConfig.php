<?php
namespace Mxs\Services\Pdo;

readonly class PdoConfig
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

    public static function mysql_host(
        string $db,
        string $host = 'localhost',
        int $port = 3306,
        string $user = 'root',
        string $password = '',
    ): self {
        /*
        mysql:host=localhost;port=3307;dbname=testdb
        mysql:unix_socket=/tmp/mysql.sock;dbname=testdb
         */
        return new self("mysql:host={$host};port={$port};dbname={$db}", $user, $password);
    }

    public static function mysql_sock(string $sock, string $db, string $user = 'root', string $password = ''): self
    {
        return new self("mysql:unix_socket={$sock};dbname={$db}", $user, $password);
    }
}