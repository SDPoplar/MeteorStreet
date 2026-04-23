<?php
namespace Mxs\Http;

use \Mxs\Http\HeaderLines\{
    Status as HeaderStatus,
};

final readonly class Response implements \Psr\Http\Message\ResponseInterface
{
    public function __construct(
        \Stringable|string|array $content,
        //  header lines
        public readonly HeaderStatus $header_status = new HeaderStatus(\SeaDrip\Http\Status::OK),
        public readonly string $header_protocol_version = '1.0',
    ) {
        $this->content = is_array($content) ? $content : ''.$content;
    }

    public function getHttpStatus(): \SeaDrip\Http\Status
    {
        return $this->header_status->status;
    }

    //  #[\Override]
    public function getStatusCode(): int
    {
        return $this->header_status->status->value;
    }

    //  #[\Override]
    public function withStatus(int $code, string $reasonPhrase = '')
    {
        return new self(
            $this->content,
            new HeaderStatus(\SeaDrip\Http\Status::from($code), $reasonPhrase),
            $this->header_protocol_version,
        );
    }

    //  #[\Override]
    public function getReasonPhrase(): string
    {
        return $this->header_status->reason_phrase;
    }

    //  #[\Override]
    public function getProtocolVersion(): string
    {
        return $this->header_protocol_version;
    }

    //  #[\Override]
    public function withProtocolVersion(string $version): self
    {
        return new self(
            $this->content,
            $this->header_status,
            $version,
        );
    }

    public function getHeader(string $name): array
    {
        return [];
    }

    public function getHeaders(): array
    {
        return [];
    }

    public readonly string|array $content;
}
