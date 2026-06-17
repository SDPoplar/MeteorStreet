<?php
namespace Mxs\Renders;

use Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use SeaDrip\Http\Status as HttpStatus;
use Override;

abstract class Http extends \Mxs\Frame\Render
{
    protected const HTML_TYPE = 'text/html';

    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
    }

    #[Override]
    public function onException(\Throwable $e): bool
    {
        //  rendor html
        $http_status = ($e instanceof MxsDevException) ? $e->http_status->value : HttpStatus::InternalServerError->value;
        $err_msg = app()->debug ? self::buildExceptionHtml($e) : '';
        $this->writeHttpResponse($http_status, self::HTML_TYPE, $err_msg);
        //  return parent::onException($e);
        return true;
    }

    #[Override]
    public function onError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $msg = app()->debug
            ? "<h1>[$errno]{$errstr}</h1>" . PHP_EOL . "<p>{$errfile} line {$errline}</p>"
            : "<h1>Error!</h1>";
        $this->writeHttpResponse(
            HttpStatus::InternalServerError->value,
            self::HTML_TYPE,
            $msg,
        );
        return true;
        //  return parent::onError($errno, $errstr, $errfile, $errline);
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
