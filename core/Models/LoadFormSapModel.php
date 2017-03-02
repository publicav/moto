<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 02.03.2017
 * Time: 17:30
 */

namespace Models;


use Base\BaseModel;

class LoadFormSapModel extends BaseModel {
    public $id;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doLoadFormSap() {
        $id = $this->id;

        $sq = "SELECT id, n_zakaz as n_order, 
                       invnumber as inv, date1 as date,  mesto as pos, description as descr,
                       num_sup as nsup
               FROM m_zakaz 
               WHERE id = :id 
            ";
        $param = [ 'id' => $id ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }

        $form = $res->fetchAll()[0];
        if ( empty( $form ) ) return false;
        $this->result = $form;
        return true;

    }
}