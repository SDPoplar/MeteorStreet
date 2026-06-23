<?php
namespace Mxs\Renders;

use SeaDrip\Http\{
    Status as HttpStatus,
    Header as HttpHeaderLine
};
use Mxs\Exceptions\Runtimes\MxsRuntime;
use Mxs\Frame\{ExecReturn, ExecReturnType};
use Override;

abstract class Http implements \Mxs\Gate\Render
{
    protected const HTML_TYPE = 'text/html';
    abstract protected function formatBody(mixed $data): string;
    abstract protected function formatException(\Throwable $e): string;
    abstract protected static function getContentType(): HttpHeaderLine;

    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
    }

    #[Override]
    public function onSuccess(mixed $response): void
    {
        if ($response instanceof ExecReturn) {
            if ($response->type === ExecReturnType::Redir) {
                $this->redirect($response->data);
                return;
            }
            if ($response->type === ExecReturnType::Created) {
                $http_status = HttpStatus::Created;
            }
            $content = $this->formatBody($response->data);
            $headers = $response->headers;
        } else {
            $content = $this->formatBody($response);
            $headers = $response instanceof \Psr\Http\Message\ResponseInterface
                ? $response->getHeaders() : [];
        }
        $http_status ??= empty($content) ? HttpStatus::NoContent : HttpStatus::OK;
        $this->writeHttpResponse($http_status->value, static::getContentType(), $content, $headers);
    }

    #[Override]
    public function onException(\Throwable $e): bool
    {
        $http_status = ($e instanceof MxsRuntime) ? $e->http_status->value : HttpStatus::InternalServerError->value;
        $msg = (app()->debug or ($http_status !== HttpStatus::InternalServerError->value)) ? $this->formatException($e) : '';
        $this->writeHttpResponse($http_status, static::getContentType(), $msg);
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
    }

    protected function redirect(string $target): void
    {
        $this->writeHttpResponse(HttpStatus::MovedPermanently->value, other_headers: ["Location: {$target}"]);
    }

    protected function writeHttpResponse(
        int $status_code,
        string $content_type = '',
        string $content = '',
        array $other_headers = []
    ): void {
        header("{$this->protocal_line} {$status_code}");
        header(HttpHeaderLine::Date());
        if (!empty($content_type)) {
            header("Content-Type: {$content_type}", true);
        }
        foreach ($other_headers as $h) {
            [$hl, $override] = $h;
            header($hl, $override ?? true);
        }
        header('Content-Length: '.strlen($content));
        foreach ($other_headers as $hl) {
            if (is_string($hl)) {
                header($hl);
            } elseif (self::isMxsHeaderLine($hl)) {
                header("{$hl[0]}", $hl[1]);
            }
        }

        echo $content;
    }

    protected static function isMxsHeaderLine(mixed $item): bool
    {
        return true
            and is_array($item)
            and (is_string($item[0] ?? null) or ($item[0] ?? null) instanceof \Stringable)
            and is_bool($item[1] ?? null)
            and true;
    }

    protected readonly string $protocal_line;
}
