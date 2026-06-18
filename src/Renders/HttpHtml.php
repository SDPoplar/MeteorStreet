<?php
namespace Mxs\Renders;

use SeaDrip\Http\Header;
use Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use Override;

class HttpHtml extends Http
{
    #[Override]
    protected function formatBody(mixed $data): string
    {
        return "{$data}";
    }

    #[Override]
    protected function formatException(\Throwable $e): string
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

    #[Override]
    protected static function getContentType(): Header
    {
        return Header::ContentType('text/html');
    }
}
