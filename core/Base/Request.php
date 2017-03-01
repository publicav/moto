<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 19:41
 */

namespace Base;

use Filter\FilterInput;

class Request {
    /**
     * @return bool
     */
    public static function isGet() {
        if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isPost() {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            return true;
        }
        return false;
    }

    /**
     * @return array $_POST
     */
    public static function getPost() {
        $validation = new FilterInput( $_POST );
        if ( is_null( $validation->getInputAll() ) ) return [];
        return $validation->getInputAll();
    }

    public static function getGet() {
        return Url::getAllParam();
    }

}