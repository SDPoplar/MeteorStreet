<?php
namespace Mxs\Renders;

abstract class Http extends \Mxs\Frame\Render
{
    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        parent::__construct($request);
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
        //var_dump($request);
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

    protected readonly string $protocal_line;
}
