<?php
namespace Mxs\Http;

class Response implements \Psr\Http\Message\ResponseInterface
{
    public function __construct(
        \Stringable|string|array $content
    ) {
        $this->content = is_array($content) ? $content : ''.$content;
    }

    public function getStatusCode(): string
    {
        return $this->header->getStatusCode();
    }

    public function withStatus(int $code, string $reasonPhrase = '')
    {
        
    }

    public readonly Responses\Header $header = new Responses\Header();
    public readonly string|array $content;
}
