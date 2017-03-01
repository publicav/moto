<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.02.2017
 * Time: 19:55
 */

namespace Models;


use Base\BaseModel;

class LastValueCounterModel extends BaseModel {
    public $counter;

    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'counter' => [ 'required', ],
        ];
    }

    public function doLastValueCounter() {
        $counter = $this->counter;
        $sq = "SELECT n_counter FROM  count  WHERE (id = :id);";
        $param = [ 'id' => $counter ];

        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $N_counter = $res->fetchAll()[0];
        if ( empty( $N_counter ) ) {
            throw new \Exception( 'Не найден номер счётчика!' );
        }
        $sq = "SELECT main.value FROM  counter_v AS main 
               WHERE (main.n_counter = :n_counter) AND (main.id_counter = :id_counter)
               ORDER BY date_create DESC LIMIT 1;";

        $param = [ 'n_counter' => $N_counter['n_counter'], 'id_counter' => $counter ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $value1 = $res->fetchAll();
        if ( !empty( $value1 ) ) $retVal = $value1[0]; else  $retVal = '';
        $result = [
            'success'  => true,
            'error'    => 'Ok',
            'id_error' => 0,
            'data'     => $retVal
        ];
        $this->result = $result;
        return true;

    }
}