<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 16:42
 */

namespace Models;

use Base\BaseModel;
use Pdo\GetAllUsers;

class UserAllModel extends BaseModel {
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [];
    }

    public function doUserAll() {
        $GetAllUsers = new GetAllUsers();
        $this->result = $GetAllUsers->getUserAll();
        return true;
    }
}