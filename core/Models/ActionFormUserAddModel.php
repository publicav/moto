<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 18:43
 */

namespace Models;

use Base\BaseModel;


class ActionFormUserAddModel extends BaseModel {
    public $user_add;
    public $pass_add;
    public $pass_repeat_add;
    public $family_add;
    public $name_add;

    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'user_add'        => [ 'required', 'rangeLogin', 'uniqueLogin', ],
            'pass_add'        => [ 'required', 'confirmPassword', 'minPassword' ],
            'pass_repeat_add' => [ 'required', ],
            'family_add'      => [ 'required', ],
            'name_add'        => [ 'required', ],

        ];
    }

    public function doActionFormUserAdd() {
        $config = $this->_config;
        $md5 = sha1( md5( md5( $this->pass_edit ) . $config['MD5'] . $this->user_edit ) );

        $sq = "INSERT INTO users_c (users, password, name, family,  ring) 
			VALUES (:users, :password, :name, :family, :ring);";

        $msg = 'Пользователь ' . $this->name_add . ' добавлен';
        $param = [
            'users'    => $this->user_add,
            'password' => $md5,
            'name'     => $this->name_add,
            'family'   => $this->family_add,
            'ring'     => $config['RING']
        ];

        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->result = $msg;
        return true;
    }

}