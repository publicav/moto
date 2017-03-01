<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 12:35
 */

namespace Base;


class Registry implements \ArrayAccess {
    private $container = array();
    protected static $_link;

    public static function init() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        return self::$_link;

    }

    public function offsetSet( $key, $value ) {
        if ( !$this->offsetExists( $key ) )
            $this->container[ $key ] = $value;
        else
            trigger_error( 'Variable ' . $key . ' already defined', E_USER_WARNING );
    }

    public function offsetGet( $key ) {
        return $this->container[ $key ];
    }

    public function offsetExists( $key ) {
        return isset( $this->container[ $key ] );
    }

    public function offsetUnset( $key ) {
        unset( $this->container[ $key ] );
    }
}