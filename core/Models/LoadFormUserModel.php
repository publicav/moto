<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 18:43
 */

namespace Models;

use Base\BaseModel;

class LoadFormUserModel extends BaseModel {
    public $id;
    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doLoadFormUser() {

        $id = $this->id;
        $sq = "SELECT id, users, password, name, family FROM users WHERE  ring > 0 AND id = :id;";

        $param = [ 'id' => $id ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $user = $res->fetchAll()[0];

        if ( empty( $user ) ) return false;

        $this->result = $user;
        return true;


    }

}