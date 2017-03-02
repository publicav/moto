<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 01.03.2017
 * Time: 19:57
 */

namespace Models;


use Base\BaseModel;

class NumberOrderModel extends BaseModel {
    public $term;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'term' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doNumberOrder() {
        $sq = "SELECT id, n_zakaz as label, 
                       invnumber as inv, date1 as date,  mesto as pos, description as decription
               FROM m_zakaz 
               WHERE ( (id_remont = 1) or (id_zakaz = 4) ) and n_zakaz LIKE  '%{$this->term}%' 
               ORDER BY id DESC
               LIMIT 0, 15;";
//(id_remont = 1) or
//        concat( invnumber, ',|', date1, ',|', mesto, ',|', description ) as decription
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $value = $res->fetchAll();
//        $result = array_column( $value, 'n_zakaz' );
        //                var_dump( $result );
        $this->result = $value;
        return true;
        //        $this->result = [
        //            'data'     => $value1
        //        ];

    }
}