<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class Log implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    protected function __construct(
        public readonly Path $log_path
    ) {}

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        file_put_contents(
            $this->log_path->merge(date('Y-m-d').'.log'),
            '['.date('Y-m-d H:i:s')."][{$level}] {$message}, context: ".json_encode($context)
        );
    }
}
