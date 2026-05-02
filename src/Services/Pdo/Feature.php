<?php
namespace Mxs\Services\Pdo;

class Feature
{
    public readonly array $operands;
    public private(set) array $context = [];

    public function &setContext(array $context): self
    {
        $this->context = $context;
        return $this;
    }

    public static function orGroup(Feature ...$feature): self
    {
        return new self(FeatureOperator::orGroup, ...$feature);
    }

    public static function andGroup(Feature ...$feature): self
    {
        return new self(FeatureOperator::andGroup, ...$feature);
    }

    public static function eq(string $column, int|float|string|bool $value): self
    {
        return new self(FeatureOperator::equal, $column, $value);
    }

    public static function neq(string $column, int|float|string|bool $value): self
    {
        return new self(FeatureOperator::notEqual, $column, $value);
    }

    public static function in(string $column, array $enumItems): self
    {
        return new self(FeatureOperator::in, $column, $enumItems);
    }

    public static function midLike(string $column, string $like_what): self
    {
        return self::like($column, "%{$like_what}%");
    }

    public static function leftLike(string $column, string $like_what): self
    {
        return self::like($column, '%'.$like_what);
    }

    public static function rightlike(string $column, string $like_what): self
    {
        return self::like($column, $like_what.'%');
    }

    protected static function like(string $column, string $like_what): self
    {
        return new self(FeatureOperator::like, $like_what);
    }

    protected function __construct(
        public readonly FeatureOperator $op,
        mixed ...$operand
    ) {
        $this->operands = $operand;
    }
}