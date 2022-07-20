<?php
namespace Mxs\Traits\Psr\Http\Message;

trait Message implements \Psr\Http\Message\MessageInterface
{
    public function getProtocolVersion() : string
    {
        return $this->_pv;
    }

    public function &withProtocolVersion( $version ) : static
    {
        $this->_pv = $version;
        return $this;
    }

    public function getHeaders()
    {
        //  todo
    }

    public function hasHeader( string $name ) : bool
    {
        return array_key_exists( strtolower( $name ), $this->_headers );
    }

    public function getHeaderLine( string $name )
    {
        //  todo
    }

    public function withHeader( string $name, $value ) : static
    {
        //  todo
        //  validate $value
        //  throw new \InvalidArgumentException();
        $this->_headers[ strtolower( $name ) ] = [ 'origin_name' => $name, 'value' => $value ];
        return $this;
    }

    public function withAddedHeader( $name, $value )
    {
        //  todo
    }

    public function &withoutHeader( string $name ) : static
    {
        unset( $this->_headers[ strtolower( $name ) ] );
        return $this;
    }

    public function getBody() : StreamInterface
    {
        if ($this->_bodyStream === null) {
            throw new \InvalidArgumentException();
        }
        return $this->_bodyStream;
    }

    public function &withBody( StreamInterface $body )
    {
        $this->_bodyStream = $body;
        return $this;
    }

    private string $_pv = '';   //  protocol version
    private ?StreamInterface $_bodyStream = null;
    private array $_headers = [];
}

