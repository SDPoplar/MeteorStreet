<?php
namespace Mxs\Base;

class MXS extends \Mxs\Abstracts\Single {
    protected $_request = null;
    protected $_response = null;
    protected $_config = null;

    protected function init() {
        $cfgFilePath = 'config/config.php';
        DEBUG_MODE && !file_exists( SRC_PATH.$cfgFilePath )
            && \Mxs\Util\DevUtil::copyTplFile( $cfgFilePath );
        $cfgFile = new \Mxs\Channel\ArrayFileChannel( $cfgFilePath );
        $this->_config = $cfgFile->valid() ? $cfgFile->get() : [];
    }

    public function run( string $processCls = \Mxs\Def\Process::class ) {
        try {
            $process = new $processCls();
            if( !is_subclass_of( $process, '\Mxs\Abstracts\Process' ) ) {
                throw new \Mxs\Error\FrameError( \Mxs\Enum\FrameErrorCode::WRONG_PARENT_PROCESS );
            }

            $process->init();
            if( !$process->valid() ) {
                return;
            }

            $this->_request = \Mxs\Base\Request::LoadRequest();
            do {
                $process->step();
            } while( $process->next() );
        } catch( \Mxs\Error\FrameError $e ) {
            echo "Frame Error:".PHP_EOL;
            var_dump( $e );
        } catch( \Exception $e ) {
            echo "Unknown Error:".PHP_EOL;
            var_dump( $e );
        }
    }

    public function &getRequest() : \Mxs\Base\Request {
        return $this->_request;
    }

    public function &getResponse() : \Mxs\Base\Response {
        if( $this->_response === null ) {
            $this->_response = new \Mxs\Base\Response();
        }
        return $this->_response;
    }

    public function setResonse( \Mxs\Base\Response &$response ) {
        $this->_response = $response;
    }
}

