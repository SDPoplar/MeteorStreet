<?php
namespace Mxs\Renders;

use SeaDrip\Http\Header;
use Mxs\Exceptions\Develops\MxsDevelop;
use Override;

class HttpXml extends Http
{
    /*
    #[Override]
    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        parent::__construct($request);
        if (!extension_loaded('xmlwriter')) {
            throw new \Mxs\Exceptions\Runtimes\PhpExtensionMissing('xmlwriter');
        }
    }
    */

    #[Override]
    protected static function getContentType(): Header
    {
        return Header::ContentType('application/xml');
    }

    #[Override]
    protected function formatBody(mixed $data): string
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    protected function formatException(\Throwable $e): string
    {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        //  xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');

        // A first element
        xmlwriter_start_element($xw, 'code');
        xmlwriter_text($xw, $e->getCode());
        xmlwriter_end_element($xw);

        // CDATA
        xmlwriter_start_element($xw, 'message');
        xmlwriter_write_cdata($xw, $e->getMessage());
        xmlwriter_end_element($xw); // message

        //  xmlwriter_write_comment($xw, 'this is a comment.');

        if (app()->debug) {
            if ($e instanceof MxsDevelop) {
                // CDATA
                xmlwriter_start_element($xw, 'proposal');
                xmlwriter_write_cdata($xw, $e->proposal);
                xmlwriter_end_element($xw); // proposal
            }

            /* TODO: trace
            xmlwriter_start_element($xw, 'trace');
            foreach ($e->getTrace() as $t) {
                // Start a child element
                xmlwriter_start_element($xw, 'tag11');
                xmlwriter_text($xw, 'This is a sample text, ä');
                xmlwriter_end_element($xw); // tag11
            }
            xmlwriter_end_element($xw); // trace
            */
        }

        xmlwriter_end_document($xw);

        return xmlwriter_output_memory($xw);
    }
}