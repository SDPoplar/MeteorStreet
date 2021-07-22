<?php
namespace Mxs;

// use \Mxs\Exceptions\{Frame as FrameErr, Runtime as RuntimeErr};
use \Mxs\Exceptions\DevelopExceptions\{
    AppRootNotDefined as ErrAppRootNotDefined,
    CoreAlreadyCreated as ErrCoreAlreadyCreated,
    GettingInvalidComponent as ErrGettingInvalidComponent,
};

class Core
{
    private function __construct()
    {
        defined('APP_ROOT') or ErrAppRootNotDefined::throm();
        Core::$ins && ErrCoreAlreadyCreated::throm(@'Do not create \Mxs\Core twice');
        $this->_env = new \Mxs\Bases\Environment(APP_ROOT, __DIR__);
        $this->_config = new \Mxs\Bases\Config($this->environment->getConfigPath());
    }

    final public static function &get() : Core
    {
        if (Core::$ins === null) {
            Core::$ins = new Core();
        }
        return Core::$ins;
    }

    public function __get(string $arg)
    {
        $method = 'get'.ucfirst($arg);
        method_exists($this, $method) or ErrGettingInvalidComponent::throm($arg);
        return $this->$method();
    }

    final protected function getEnvironment() : \Mxs\Bases\Environment
    {
        return $this->_env;
    }

    final protected function getConfig() : \Mxs\Bases\Config
    {
        return $this->_config;
    }

    final public function run(string $process = \Mxs\Bases\Process\Http::class) : void
    {
        /*
        $this->valid() or die( $this->getLastErrorMessage() );
        //  $lastRet = \Mxs\Requests\Tool::getOriginRequest();
        $steps = $this->parseStepsFromGivenProcess( $process );
        try {
            while (!empty( $steps )) {
                $lastRet = ( array_shift( $steps ) )->run( $lastRet ?? null );
            }
        } catch( \Exception $e ) {
            $lastRet = json_encode( [ 'code' => $e->getCode(), 'message' => $e->getMessage() ] );
        }
        echo $lastRet;
        */
        (new $process())->run();
    }

    private function parseStepsFromGivenProcess( string $processClass ) : array
    {
        $p = new $processClass();
        $p->plan();
        $p->valid() or die( 'Invalid process given' );
        return $p->getSteps();
    }

    protected $_config;
    protected \Mxs\Bases\Environment $_env;

    private static ?\Mxs\Core $ins = null;
}

