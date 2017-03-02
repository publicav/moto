<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 02.03.2017
 * Time: 23:08
 */

namespace Models;


use Base\BaseModel;

class ActionFormSapModel extends BaseModel {
    public $sap_id;
    public $nsup;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'sap_id'   => [ 'required', 'aboveZerroInt', ],
            'nsup' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doActionFormSap() {
        $config = $this->_config;

        $sq = "UPDATE m_zakaz SET num_sup=:nsup WHERE (id = :id);";

        $msg = 'Номер удачно изменён';
        $param = [
            'id'   => $this->sap_id,
            'nsup' => $this->nsup,
        ];

        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->result = $msg;

        return true;

    }

}