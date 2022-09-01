<?php
namespace Mxs\Http;

class Response
{
    public function __construct(int|Status $status,\Stringable|string|array $content)
    {
        $this->status = is_int($status) ? Status::from($status) : $status;
        $this->content = is_array($content) ? $content : ''.$content;
    }

    public readonly Status $status;
    public readonly string|array $content;
}
