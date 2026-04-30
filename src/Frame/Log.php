<?php
namespace Mxs\Frame;

use \SeaDrip\Tools\Path;

class Log implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    public function __construct(
        public readonly Path $log_path
    ) {}

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $log_content = '['.date('Y-m-d H:i:s')."][{$level}] {$message}";
        if (!empty($context)) {
            $log_content .= ', context: '.json_encode($context);
        }
        file_put_contents($this->log_path->merge(date('Y-m-d').'.log'), $log_content.PHP_EOL.PHP_EOL, FILE_APPEND);
    }
}
