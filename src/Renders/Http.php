<?php
namespace Mxs\Renders;

use Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use SeaDrip\Http\Status as HttpStatus;

abstract class Http extends \Mxs\Frame\Render
{
    protected const HTML_TYPE = 'text/html';

    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        parent::__construct($request);
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
        //var_dump($request);
    }

    #[\Override]
    public function onException(\Throwable $e): bool
    {
        //  save log
        $log_msg = ($e instanceof MxsDevException) ? $e->getMessage() . PHP_EOL . $e->proposal : $e->getMessage();
        app()->logger->error(implode(PHP_EOL, [$log_msg, ...$e->getTrace()]));

        //  rendor html
        $http_status = ($e instanceof MxsDevException) ? $e->http_status->value : HttpStatus::InternalServerError->value;
        $err_msg = app()->debug ? self::buildExceptionHtml($e) : '';
        $this->writeHttpResponse($http_status, self::HTML_TYPE, $err_msg);
        //  return parent::onException($e);
        return true;
    }

    protected function redirect(string $target): void
    {
        $this->writeHttpResponse(
            HttpStatus::MovedPermanently->value,
            self::HTML_TYPE,
            "",
            "Location: {$target}"
        );
    }

    protected static function packExceptionTrace(array $trace): array
    {
        return array_map(function($line): string {
            return "{$line['class']}{$line['type']}{$line['function']}({$line['file']} line {$line['line']})";
        }, $trace);
    }

    protected function writeHttpResponse(
        int $status_code,
        string $content_type,
        string $content,
        string ...$other_headers
    ): void {
        header("{$this->protocal_line} {$status_code}");
        header('Date: '.(new \DateTime())->format(\DateTime::RFC1123));
        header("Content-Type: {$content_type}");
        foreach ($other_headers as $h) {
            header($h);
        }
        header('Content-Length: '.strlen($content));

        echo $content;
    }

    private static function buildExceptionHtml(\Throwable $e): string
    {
        $trace_lines = array_map(function ($line): string {
            return "<li><strong>{$line['class']}{$line['type']}{$line['function']}</strong><br />"
                ."<small>{$line['file']} line {$line['line']}</small></li>";
        }, $e->getTrace());
        $trace_list = implode(PHP_EOL, $trace_lines);
        $propsal_line = ($e instanceof MxsDevException) ? "<p>{$e->proposal}</p>" : '';
        $html = <<<HTML
<!Doctype html>
<html>
<head><title>Error!</title></head>
<body>
  <h1>{$e->getMessage()}</h1>
  {$propsal_line}
  <h3>Trace:</h3>
  <ol>{$trace_list}</ol>
</body>
</html>
HTML;
        return $html;
    }

    protected readonly string $protocal_line;
}
