<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.02.2017
 * Time: 16:40
 */

namespace Models;


use Base\BaseModel;
use Pdo\Privelege;

class MenuLeftModel extends BaseModel {
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [];
    }

    public function doMenuLeft() {
        $id_users = $this->_route->getAuthorization();

        if ( $id_users > 0 ) {
            $menuLeft = new Privelege( $id_users );
            $menu_left_m = $menuLeft->getMenuLeft();
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $menu_left_m
            ];
            return true;
        }
        $this->result = null;
        return false;
    }

}