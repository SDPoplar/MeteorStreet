<?php
namespace Mxs\Frame;

final readonly class ExecReturn
{
    public static function redir(string $target): self
    {
        return new self(ExecReturnType::Redir, $target);
    }

    public static function created(int|array $data): self
    {
        if (is_int($data)) {
            $data = ['id' => $data];
        }
        return new self(ExecReturnType::Created, $data);
    }

    public static function succ(?array $data = null): self
    {
        return new self(ExecReturnType::Success, $data);
    }

    protected function __construct(
        public ExecReturnType $type,
        public array|string|null $data,
    ) {}
}