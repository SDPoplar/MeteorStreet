<?php
namespace Mxs\Components;

use Stringable;

use \SeaDrip\Tools\Path;

class Log implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    public function __construct(string $log_path)
    {
        $this->log_path = $log_path;
    }

    public function log($level, string|Stringable $message, array $context = []): void
    {
        file_put_contents(new Path($this->log_path, date('Y-m-d').'.log'), '['.date('Y-m-d H:i:s')."][{$level}] {$message}");
    }

    protected readonly string $log_path;
}
