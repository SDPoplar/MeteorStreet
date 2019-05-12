<?php
namespace Mxs\Base;

class ChannelPattern {
    protected $_rules = [];
    protected $_page = 1;
    protected $_size = 0;       //  0 = get all

    public function __construct( Array $rules = [], $page = 1, $size = 0 ) {
        $this->_rules = $rules;
        $this->_page = $page;
        $this->_size = $size;
    }

    public static function Rule( Array $rules ) : ChannelPattern {
        return new ChannelPattern( $rules );
    }

    public static function Keys( $keys ) : ChannelPattern {
        return new ChannelPattern( [ 'key' => $keys ] );
    }

    public function valid() : bool {
        return ( $this->_page > 0 ) && ( $this->_size >= 0 );
    }

    public function getAllRules() : Array {
        return $this->_rules;
    }

    public function getRuleByName( string $name ) {
        return $this->_rules[ $name ] ?? null;
    }

    public static function MakeEmptyPattern() {
        return new ChannelPattern();
    }
}

