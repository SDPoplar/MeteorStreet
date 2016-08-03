<?php
namespace MxsClass\Base;

class MxsConfiger {
    protected $_baseConfig = [];
    protected $_appCfgPath;
    protected $_cfgFileExt = ".cfg.php";
    const DEF_CFG_CONTENT = "<?php\nreturn [\n    //  \'item\' => \'value\',\n];\n\n";

    public function __construct() {
        //  App config path
        $this->_appCfgPath = _MXS_SRC_PATH.'config/';
        DEBUG_MODE && $this->_makeDefaultFiles();
        $appCfgFileName = $this->_makeAppConfigName();
        file_exists( $appCfgFileName ) || die( 'No default config file' );
        $appConf = include( $appCfgFileName ) ?: [];
        if( array_key_exists( 'LOAD_CONFIG', $appConf ) ) {
            foreach( MxsUtils::to_array( $appConf[ 'LOAD_CONFIG' ] ) as $cfgItem ) {
                $itemName = $this->_makeAppConfigName( trim( $cfgItem ) );
                if( ! file_exists( $itemName ) ) {
                    continue;
                }
                $item = include( $itemName );
                if( ! is_array( $item ) ) {
                    $item = [];
                }
                $appConf = array_merge( $appConf, $item );
            }
        }
        $this->_baseConfig = array_merge( $this->_baseConfig, $appConf );
    }

    protected function _makeAppConfigName( $fileName = 'config' ) {
        return $this->_appCfgPath.$fileName.$this->_cfgFileExt;
    }

    private function _makeDefaultFiles() {
        is_dir( $this->_appCfgPath ) || mkdir( $this->_appCfgPath )
            || die( 'cannot make path: '.$this->_appCfgPath );
        $appDefCfgFile = $this->_makeAppConfigName();
        file_exists( $appDefCfgFile ) || file_put_contents( $appDefCfgFile, self::DEF_CFG_CONTENT ) 
            || die( 'cannot create default config file: '.$appDefCfgFile );
    }

    public function getItem( $name, $defval = null ) {
        return array_key_exists( $name, $this->_baseConfig )
            ? $this->_baseConfig[ $name ] : $defval;
    }
}
