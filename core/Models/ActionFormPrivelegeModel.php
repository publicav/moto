<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 20:45
 */

namespace Models;

use Base\BaseModel;
use Base\LeftMenu;
use Pdo\GetMenuLeft;
use Pdo\Privelege;

class ActionFormPrivelegeModel extends BaseModel {
    public $id_user;
    public $data;
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id_user' => [ 'required', 'isPositive', ],
            'data'    => [ 'required', ],

        ];
    }

    public function doActionFormPrivelege() {
        $dataCheck = explode( ",", $this->data );
        $id_user = $this->id_user;

        $privelegeData = new Privelege( $id_user );
        $getMenuLeftData = new GetMenuLeft();
        $leftMenu = new LeftMenu( $privelegeData, $getMenuLeftData );
        $leftMenu->setSqlData( $dataCheck )->savePrivelegeForm();
        return true;
    }
}