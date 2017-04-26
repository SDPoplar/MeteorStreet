<?php
namespace Mxs\Base;

class Configer {
    protected $_baseConfig = [];
    protected $_appCfgPath;
    const CFG_FILE_EXT = ".cfg.php";
    const DEF_CFG_CONTENT = "<?php\nreturn [\n    //  \'item\' => \'value\',\n];\n\n";

    public function __construct() {
        //  App config path
        $this->_appCfgPath = _MXS_SRC_PATH.'config/';
        DEBUG_MODE && $this->_makeDefaultFiles();
        $this->_baseConfig = self::loadConfigFile( self::_makeConfigFileName( 'config.def', MXS_PATH.'Conf/' ) );
        $appCfgFileName = self::_makeConfigFileName( 'config', $this->_appCfgPath );
        $appConf = self::loadConfigFile( $appCfgFileName );
        $this->_baseConfig = array_merge( $this->_baseConfig, $appConf );
    }

    static protected function _makeConfigFileName( $fileName, $filePath = null ) {
        $finalPath = $filePath ?: "";
        return $finalPath.$fileName.self::CFG_FILE_EXT;
    }

    private function _makeDefaultFiles() {
        is_dir( $this->_appCfgPath ) || mkdir( $this->_appCfgPath )
            || die( 'cannot make path: '.$this->_appCfgPath );
        $appDefCfgFile = self::_makeConfigFileName( 'config', $this->_appCfgPath );
        file_exists( $appDefCfgFile ) || file_put_contents( $appDefCfgFile, self::DEF_CFG_CONTENT ) 
            || die( 'cannot create default config file: '.$appDefCfgFile );
    }

    public function getItem( $name, $defval = null ) {
        return array_key_exists( $name, $this->_baseConfig )
            ? $this->_baseConfig[ $name ] : $defval;
    }

    static public function loadConfigFile( $cfgFileName, $filePath = null ) {
        if( ! file_exists( $cfgFileName ) ) {
            return [];
        }
        $finalPath = $filePath ?: dirname( $cfgFileName ).'/';
        $appConf = include( $cfgFileName ) ?: [];
        if( array_key_exists( 'LOAD_CONFIG', $appConf ) ) {
            foreach( MxsUtils::to_array( $appConf[ 'LOAD_CONFIG' ] ) as $cfgItem ) {
                $itemName = self::_makeConfigFileName( trim( $cfgItem ), $finalPath );
                $item = self::loadConfigFile( $itemName );
                $appConf = array_merge( $appConf, $item );
            }
        }
        return $appConf;
    }
}
