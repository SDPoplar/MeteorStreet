<?php
namespace Mxs\Gate;

interface Input
{
    public function getMethod(): string;
    public function getPath(): string;
    public function setRouteParams(array $params);
    public function input(string $column, mixed $def_val = null): mixed;
    public function allInputs(): array;
    public function &appendMid(string $name, mixed $value): static;
    public function &insteadMid(string $getter, string $name, callable $trans, ?string $rename = null): static;
}