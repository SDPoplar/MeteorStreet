<?php
namespace Mxs\Services\Pdo;

abstract class PdoService
{
    abstract protected function selectTable(?Feature $f): string;

    public function __construct(PdoConfig $cfg)
    {
        try {
            $this->pdo_ins = new \PDO($cfg->getDsn(), $cfg->user, $cfg->password);
        } catch (\PDOException $e) {
            throw new \Mxs\Exceptions\Runtimes\ConnectServiceFailed('pdo connnect failed', $e);
        }
    }

    public function getOne(Feature $feature): ?array
    {
        $sql = $this->pdo_ins->query('select * from '.static::selectTable($feature).' where '.self::transFeature($feature));
        return $sql->fetchAll(\PDO::FETCH_ASSOC)[0] ?? null;
    }

    public function getList(?Feature $feature = null, int $offset = 0, int $size = 0, string $order = ''): ?array
    {
        $sql_parts = ['select * from '.static::selectTable($feature)];
        if (!is_null($feature)) {
            $sql_parts[] = 'where '.static::transFeature($feature);
        }
        if ($size > 0) {
            $sql_parts[] = 'limit '.($offset > 0 ? $offset.',' : '').$size;
        }
        if (!empty($order)) {
            $sql_parts[] = $order;
        }
        $sql = $this->pdo_ins->query(implode(' ', $sql_parts));
        return $sql->fetchAll(\PDO::FETCH_ASSOC) ?: null;
    }

    protected static function transFeature(Feature $f): string
    {
        return '('.match($f->op) {
            FeatureOperator::andGroup => implode(' and ', array_map(fn($item): string => static::transFeature($item),  $f->operands)),
            FeatureOperator::orGroup => implode(' or ', array_map(fn($item): string => static::transFeature($item),  $f->operands)),
            FeatureOperator::equal => static::packColumn($f->operands[0]).' = '.static::packValue($f->operands[1]),
            FeatureOperator::notEqual => static::packColumn($f->operands[0]).' != '.static::packValue($f->operands[1]),
            FeatureOperator::lessThan => static::packColumn($f->operands[0]).' < '.static::packValue($f->operands[1]),
            FeatureOperator::greaterThan => static::packColumn($f->operands[0]).' > '.static::packValue($f->operands[1]),
            FeatureOperator::lessThanOrEqual => static::packColumn($f->operands[0]).' <= '.static::packValue($f->operands[1]),
            FeatureOperator::greaterThanOrEqual => static::packColumn($f->operands[0]).' >= '.static::packValue($f->operands[1]),
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
            'string' => '"'.str_replace($value, '"', '\\"').'"',
            'bool' => $value ? 'true' : 'false'
        };
    }

    private \PDO $pdo_ins;
}
