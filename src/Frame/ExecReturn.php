<?php
namespace Mxs\Frame;

final class ExecReturn
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

    public function &header(string|\SeaDrip\Http\Header $header, bool $override = true): self
    {
        $this->headers[] = ["{$header}", $override];
        return $this;
    }

    public function &cookie(): self
    {
        return $this;
    }

    protected function __construct(
        public readonly ExecReturnType $type,
        public readonly array|string|null $data,
    ) {}

    public private(set) array $headers = [];
}