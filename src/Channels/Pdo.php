<?php
namespace Mxs\Channels;

abstract class Pdo extends Base
{
    protected function __construct(
        public readonly \Mxs\Configs\PdoConfig $connection,
        public readonly string $table,
    ) {}

    protected function select(
        array|string $columns = '*',
        array $where = [],
        array|string $order = [],
        int $page = 1,
        int $page_size = 0,
    ): array|false {
        if (empty($columns)) {
            $columns = '*';
        } else {
            $columns = is_array($columns) ? implode(',', $columns) : $columns;
        }
        if (empty($order)) {
            $order_str = '';
        } elseif (is_array($order)) {
            $order_str = implode(',', array_map(fn($key, $val) => "{$key} {$val}", array_keys($order), $order));
        } else {
            $order_str = $order;
        }
        if (!empty($order_str)) {
            $order_str = ('order by ' . $order_str);
        }
        $where_str = self::translateFilter($where);
        $sql = "select {$columns} from {$this->table} {$where_str} {$order_str}";
        return $this->query($sql);
    }

    protected function count(array $where = []): int
    {
        $where_str = self::translateFilter($where);
        $sql = "select count(*) as record_num from {$this->table} {$where_str} limit 1";
        $got = $this->query($sql)[0] ?? null;
        return $got ? ($got['record_num'] ?? 0) : 0;
    }

    protected function update(array $where, array $changes): int|false
    {
        $changes_str = implode(',', array_map(fn($key, $val) => "`{$key}` = {$val}", array_keys($changes), $changes));
        $where_str = self::translateFilter($where);
        $sql = "update {$this->table} set {$changes_str} where {$where_str}";
        return $this->execute($sql);
    }
    
    protected function insert(array $columns, bool $get_id = false): int
    {
        $driver =& $this->getDriver();
        $c = implode(',', array_keys($columns));
        $sql = "insert into {$this->table} ({$c}) values ()";
        $ret = $driver->exec($sql);
        return $get_id && ($ret !== false) ? $driver->lastInsertId() : 0;
    }

    protected function delete()
    {}

    protected function query(string $sql): array|false
    {
        $state = $this->getDriver()->query($sql, \PDO::FETCH_ASSOC);
        if ($state === false) {
            return false;
        }
        foreach ($state as $row) {
            $ret[] = $row;
        }
        return $ret ?? [];
    }

    protected function execute($sql): int|false
    {
        return $this->getDriver()->exec($sql);
    }

    private static function translateFilter(array $where = []): string
    {
        return '';
    }

    private function &getDriver(): \PDO
    {
        return DriverManager::pdo(
            $this->connection->dsn,
            $this->connection->user_name,
            $this->connection->password,
            $this->connection->options
        );
    }
}
