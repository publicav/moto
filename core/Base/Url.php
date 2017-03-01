<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 21.02.2017
 * Time: 16:45
 */

namespace Base;

use Filter\FilterInput;

class Url {
    /**
     * @return mixed
     */
    private static function getSegmentsFromUrl() {

        if ( !isset( $_GET['url'] ) ) return null;
        $segments = explode( '/', $_GET['url'] );
        if ( empty( $segments[ count( $segments ) - 1 ] ) ) {
            unset( $segments[ count( $segments ) - 1 ] );
        }
        $segments = array_map( function ( $value ) {
            return preg_replace( '/[\'\\\*]/', '', $value );
        }, $segments );
        $segments = FilterInput::init( $segments )->getInputAll();
        return $segments;
    }

    private static function getParamsFromUrl() {
        $params = $_GET;
        unset( $params['url'] );
        return FilterInput::init( $params )->getInputAll();
    }


    /**
     * @param string $paramName
     * @return string|null
     */
    public static function getParam( $paramName ) {
        $params = self::getParamsFromUrl();
        return $params[ $paramName ];
    }

    /**
     * @param int $key
     * @return string|null
     */
    public static function getSegment( $key ) {
        $segment = self::getSegmentsFromUrl();
        if ( isset( $segment[ $key ] ) ) {
            return $segment[ $key ];
        }
        return null;
    }

    /**
     * @return array;
     */
    public static function getAllSegments() {
        return self::getSegmentsFromUrl();
    }

    /**
     * @return string
     */
    public static function getUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getAllParam() {
        $params = self::getParamsFromUrl();
        if ( is_null( $params ) ) return [];
        return $params;
    }

}