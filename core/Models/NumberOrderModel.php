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
        $sq = "SELECT id, n_zakaz as label, concat( date1, ' ', mesto ) as decription
               FROM m_zakaz 
               WHERE n_zakaz LIKE  '%{$this->term}%' 
               ORDER BY id DESC
               LIMIT 0, 15;";

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