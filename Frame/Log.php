<?php
namespace Mxs\Frame;

use Stringable;

use \SeaDrip\Tools\Path;

class Log extends \SeaDrip\Abstracts\Signleton implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    protected function __construct()
    {
        $this->log_path = FileStructure::Get()->getLogPath();
    }

    public function log($level, string|Stringable $message, array $context = []): void
    {
        file_put_contents(
            new Path($this->log_path, date('Y-m-d').'.log'),
            '['.date('Y-m-d H:i:s')."][{$level}] {$message}, context: ".json_encode($context)
        );
    }

    protected readonly string $log_path;
}
