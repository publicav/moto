<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.01.2017
 * Time: 22:23
 */

namespace Exception;


class JsonError {
    public static function exitError($success, $id_error, $errorName ){
        $type['success'] = $success;
        $type['id_error'] = $id_error;
        $type['error'] = $errorName;
        return json_encode( $type );
    }
}