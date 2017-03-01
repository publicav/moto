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

class LoadFormPrivelegeModel extends BaseModel {
    public $id_user;
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id_user' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doLoadFormPrivelege() {

        $id_user = $this->id_user;

        $privelege = new Privelege( $id_user );
        $getMenuLeft = new GetMenuLeft();
        $leftMenu = new LeftMenu( $privelege, $getMenuLeft );
        $menuLeftPriv = $leftMenu->getDataForm();

        $this->result = $menuLeftPriv;
        return true;
    }

}