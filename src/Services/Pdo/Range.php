<?php
namespace Mxs\Services\Pdo;

final class Range
{
    public function __construct(
        public private(set) int $offset = 0,
        public private(set) int $size = -1,
        public private(set) ?bool $reverse = null,
        public private(set) string $order_column = '',
    ) {}

    public function &limit(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function &range(int $offset, int $size): self
    {
        $this->offset = $offset;
        return $this->limit($size);
    }

    public function &orderAsc(string $column): self
    {
        $this->reverse = false;
        $this->order_column = $column;
        return $this;
    }

    public function &orderDesc(string $column): self
    {
        $this->reverse = true;
        $this->order_column = $column;
        return $this;
    }
}
