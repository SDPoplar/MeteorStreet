<?php
namespace Mxs\Services\Pdo;

abstract class PdoService
{
    abstract protected function selectTable(mixed $table_route): string;
    //  abstract protected static function createPdoInstance();

    public function __construct(PdoConfig $cfg)
    {
        try {
            $this->pdo_ins = new \PDO($cfg->getDsn(), $cfg->user, $cfg->password);
        } catch (\PDOException $e) {
            throw new \Mxs\Exceptions\Runtimes\ConnectServiceFailed('pdo connnect failed', $e);
        }
    }

    public function getOne(Feature $feature, mixed $table_route = null): ?array
    {
        $sql = $this->pdo_ins->query('select * from '.static::selectTable($table_route).' where '.self::transFeature($feature));
        return $sql->fetchAll(\PDO::FETCH_ASSOC)[0] ?? null;
    }

    public function getList(?Feature $feature = null, int $offset = 0, int $size = 0, string $order = '', mixed $table_route = null): ?array
    {
        $sql_parts = ['select * from '.static::selectTable($table_route)];
        if (!is_null($feature)) {
            $sql_parts[] = 'where '.static::transFeature($feature);
        }
        if ($size > 0) {
            $sql_parts[] = 'limit '.($offset > 0 ? $offset.',' : '').$size;
        }
        if (!empty($order)) {
            $order_parts = explode(' ', $order);
            $sql_parts[] = 'order by '.static::packColumn($order_parts[0]).' '.($order_parts[1] ?? 'asc');
        }
        $sql = $this->pdo_ins->query(implode(' ', $sql_parts));
        return $sql->fetchAll(\PDO::FETCH_ASSOC) ?: null;
    }

    public function insertOne(array $valueMap, ?string $primary_key = null, mixed $table_route = null): int|string|false
    {
        //  TODO: what to do if empty($valueMap)
        foreach ($valueMap as $column => $val) {
            $fields[] = static::packColumn($column);
            $values[] = static::packValue($val);
        }
        $sql_str = 'insert into ' . static::selectTable($table_route).' ('.implode(', ', $fields ?? []).') values ('.implode(', ', $values ?? []).')';
        $exec_result = $this->pdo_ins->exec($sql_str);
        if ($exec_result === false) {
            return false;
        }
        //  get last insert id ?
        $last_insert_id = $this->pdo_ins->lastInsertId($primary_key);
        return is_numeric($last_insert_id) ? intval($last_insert_id) : $last_insert_id;
    }

    public function change(Feature $feature, array $newValueMap, mixed $table_route = null): int|false
    {
        //  TODO: what to do if empty($newValueMap)
        foreach ($newValueMap as $column => $val) {
            $nv[] = static::packColumn($column).' = '.static::packValue($val);
        }
        $sql_str = 'update '.static::selectTable($table_route).' set '.implode(', ', $nv ?? []).' where '.static::transFeature($feature);
        return $this->pdo_ins->exec($sql_str);
    }

    protected static function transFeature(Feature $f): string
    {
        ;
        return '('.match($f->op) {
            FeatureOperator::andGroup => implode(' and ', array_map(fn($item): string => static::transFeature($item),  $f->operands)),
            FeatureOperator::orGroup => implode(' or ', array_map(fn($item): string => static::transFeature($item),  $f->operands)),
            FeatureOperator::equal => static::packColumn($f->operands[0]).' = '.static::packValue($f->operands[1]),
            FeatureOperator::notEqual => static::packColumn($f->operands[0]).' != '.static::packValue($f->operands[1]),
            FeatureOperator::lessThan => static::packColumn($f->operands[0]).' < '.static::packValue($f->operands[1]),
            FeatureOperator::greaterThan => static::packColumn($f->operands[0]).' > '.static::packValue($f->operands[1]),
            FeatureOperator::lessThanOrEqual => static::packColumn($f->operands[0]).' <= '.static::packValue($f->operands[1]),
            FeatureOperator::greaterThanOrEqual => static::packColumn($f->operands[0]).' >= '.static::packValue($f->operands[1]),
            FeatureOperator::in => static::packColumn($f->operands[0]).' in ('.implode(', ', array_map(
                fn(int|float|string|bool $item): string => self::packValue($item),
                $f->operands[1]
            )).')',
            FeatureOperator::like => static::packColumn($f->operands[0]).' like '.static::packValue($f->operands[1]),
            //  TODO: other operators
        }.')';
    }

    protected static function packColumn(string $column): string
    {
        return $column;
    }

    protected static function packValue(int|float|string|bool $value): string
    {
        return match(gettype($value)) {
            'int', 'integer', 'float', 'double' => $value,
            'string' => '"'.str_replace('"', '\\"', $value).'"',
            'bool' => $value ? 'true' : 'false'
        };
    }

    /*  TODO: redesign pdo instance rule (pool or singlton)
    protected static function getPdoIns(): \PDO
    {}
    */

    private \PDO $pdo_ins;
}
