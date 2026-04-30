<?php
namespace Mxs\Renders;

use Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;

abstract class Http extends \Mxs\Frame\Render
{
    protected const HTML_TYPE = 'text/html';

    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        parent::__construct($request);
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
        //var_dump($request);
    }

    protected function renderDevelopException(MxsDevException $e): bool
    {
        $trace_lines = array_map(function($line): string {
            return "{$line['class']}{$line['type']}{$line['function']}({$line['file']} line {$line['line']})";
        }, $e->getTrace());
        app()->logger->error(implode(PHP_EOL, array_merge([$e->getMessage(), $e->proposal], $trace_lines)));
        $err_msg = app()->debug ? self::buildDevExceptionHtml($e) : '';
        $this->writeHttpResponse($e->http_status->value, self::HTML_TYPE, $err_msg);
        return false;
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

    private static function buildDevExceptionHtml(MxsDevException $e): string
    {
        $trace_lines = array_map(function ($line): string {
            return "<li><strong>{$line['class']}{$line['type']}{$line['function']}</strong><br />"
                ."<small>{$line['file']} line {$line['line']}</small></li>";
        }, $e->getTrace());
        $trace_list = implode(PHP_EOL, $trace_lines);
        $html = <<<HTML
<!Doctype html>
<html>
<head><title>Error!</title></head>
<body>
  <h1>{$e->getMessage()}</h1>
  <p>{$e->proposal}</p>
  <h3>Trace:</h3>
  <ol>{$trace_list}</ol>
</body>
</html>
HTML;
        return $html;
    }

    protected readonly string $protocal_line;
}
