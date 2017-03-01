<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 18:43
 */

namespace Models;

use Base\BaseModel;

class LoadFormValueModel extends BaseModel {
    public $id;
    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doLoadFormValue() {

        $id = $this->id;

        $sq = "SELECT main.id AS id, lot.id AS lot_id, sub.id AS sub_id, cnt.id AS counter_id, cnt.name AS counter, 
                DATE_FORMAT(main.date_create, '%d-%m-%Y' ) AS date1, DATE_FORMAT(main.date_create, '%H:%i' ) AS time1 ,main.value AS value,
                sub.name AS substation, lot.name AS lot
        FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot
        WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (main.id = :id)
        ";

        $param = array( 'id' => $id );
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $editCounter = $res->fetchAll()[0];
        if ( empty( $editCounter ) ) return false;

        $this->result = $editCounter;
        return true;


    }

}