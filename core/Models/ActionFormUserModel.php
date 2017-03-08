<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 18:43
 */

namespace Models;

use Base\BaseModel;


class ActionFormUserModel extends BaseModel {
    public $edit_user_id;
    public $user_edit;
    public $pass_edit;
    public $pass_repeat_edit;
    public $family_edit;
    public $name_edit;

    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'user_edit'        => [ 'required', 'rangeLogin',  ],
            'pass_edit'        => [ 'required', 'confirmPassword', 'minPassword' ],
            'pass_repeat_edit' => [ 'required', ],
            'family_edit'      => [ 'required', ],
            'name_edit'        => [ 'required', ],
            'edit_user_id'     => [ 'required', ],
        ];
    }

    public function doActionFormUser() {
        $config = $this->_config;
        $md5 = sha1( md5( md5( $this->pass_edit ) . $config['MD5'] . $this->user_edit ) );
        $sq = "UPDATE users  
			SET users = :users, password = :password, name = :name, family = :family, ring = :ring
			WHERE (id = :id);";

        $msg = 'Пользователь ' . $this->name_edit . ' изменён';
        $param = [
            'users'    => $this->user_edit,
            'password' => $md5,
            'name'     => $this->name_edit,
            'family'   => $this->family_edit,
            'ring'     => $config['RING'],
            'id'       => $this->edit_user_id,
        ];

        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->result = $msg;

        return true;
    }

}