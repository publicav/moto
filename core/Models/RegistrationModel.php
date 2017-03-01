<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.02.2017
 * Time: 18:49
 */

namespace Models;


use Base\Auth;
use Base\BaseModel;

class RegistrationModel extends BaseModel {
    public $username;
    public $password;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'username' => [ 'required', ],
            'password' => [ 'required', ],
        ];
    }

    public function doRegistration() {
        $config = $this->_config;

        $username = $this->username;
        $password = $this->password;
        $md5 = sha1( md5( md5( $password ) . $config['MD5'] . $username ) );

        $sq = "SELECT id, users, name, family FROM users_c WHERE (users = :user) AND (password = :password)";

        $res = $this->_pdo->prepare( $sq );
        $param = [ 'user' => $username, 'password' => $md5 ];
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $regArray = $res->fetchAll();

        if ( empty( $regArray ) ) {
            throw new \Exception( 'Ошибка регистрации!' );
        }
        $registred = $regArray[0];
        $id = $registred['id'];
        Auth::login( $id );


        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'id'       => $id,
            'users'    => $registred['users'],
            'name'     => $registred['name'],
            'family'   => $registred['family'],
            'message'  => $registred['users'],
        ];

        return true;

    }
}