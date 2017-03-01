<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 24.02.2017
 * Time: 18:06
 */

namespace Models;


use Base\BaseModel;
use Exception\InputException;
use Filter\ValidDependentFilters;
use Filter\ValidDublicate;

class ActionFromValueModel extends BaseModel {
    public $lot;
    public $substation;
    public $counter;
    public $counter_val;
    public $date_begin;
    public $time_begin;
    public $actions;
    public $edit_id;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'lot'         => [ 'required', 'isPositive', ],
            'substation'  => [ 'required', 'isPositive', ],
            'counter'     => [ 'required', 'isPositive', ],
            'counter_val' => [ 'required', 'notEmpty', ],
            'date_begin'  => [ 'required', 'DateDMY', ],
            'time_begin'  => [ 'required', 'TimeSet', ],
            'actions'     => [ 'required', ],

        ];
    }

    public function doActionFromValue() {
        $id_users = $this->_route->getAuthorization();

        if ( is_null( $id_users ) ) {
            throw new InputException( 'Пользователь не авторизирован' );
        }

        $this->counter_val = str_replace( ',', '.', $this->counter_val );
        $this->counter_val = floatval( $this->counter_val );

        $lot = $this->lot;
        $substation = $this->substation;
        $counter = $this->counter;
        $date = $this->date_begin;
        $time = $this->time_begin;
        $dt = new \DateTime( $date );
        $date = $dt->format( 'Y-m-d' );
        $validatorDepender = new ValidDependentFilters( $lot, $substation, $counter );
        if ( !$validatorDepender->valide() ) {
            throw new InputException( 'Неправильные параметры фильтров' );
        }
        $countData = $validatorDepender->getCountData();
        $N_counter = $countData['n_counter'];

        $name_count = $countData['name'];
        $name_substation = $validatorDepender->getSubstationData()['name'];
        $name_lot = $validatorDepender->getLotData()['name'];

        $date_create = $date . ' ' . $time;

        $param = [ 'id'          => NULL,
                   'n_counter'   => $N_counter,
                   'id_counter'  => $counter,
                   'id_users'    => $id_users,
                   'value'       => $this->counter_val,
                   'date_create' => $date_create
        ];
        $id_add = 0;
        if ( $this->actions == 'add' ) {

            $sq = "SELECT id FROM  counter_v  
			       WHERE (n_counter = :n_counter) AND (id_counter = :id_counter) AND (date_create = :date_create);";
            $paramDublicate = [
                'n_counter'   => $N_counter,
                'id_counter'  => $this->counter,
                'date_create' => $date_create
            ];
            $dublicate = new ValidDublicate( $this->_pdo, $sq, $paramDublicate );
            if ( $dublicate->valide() ) {
                throw new InputException( 'Error, Дублирующая запись' );
            }

            $sq = "REPLACE INTO counter_v (id, n_counter, id_counter, id_users, value,  date_create) 
		           VALUES (:id, :n_counter , :id_counter, :id_users, :value, :date_create);";
            $res = $this->_pdo->prepare( $sq );
            if ( !$res->execute( $param ) ) {
                throw new \Exception( $this->_pdo->errorInfo()[2] );
            }
            $id_add = $this->_pdo->lastInsertId();
        }


        if ( $this->actions == 'edit' ) {
            $sq = "REPLACE INTO counter_v (id, n_counter, id_counter, id_users, value,  date_create) 
		           VALUES (:id, :n_counter , :id_counter, :id_users, :value, :date_create);";

            $param['id'] = $this->edit_id;
            $res = $this->_pdo->prepare( $sq );
            if ( !$res->execute( $param ) ) {
                throw new \Exception( $this->_pdo->errorInfo()[2] );
            }
            $id_add = $this->edit_id;
        }
        $data = [ "id"              => $id_add,
                  "lot"             => $this->lot,
                  "substation"      => $this->substation,
                  "counter"         => $this->counter,
                  "name_lot"        => $name_lot,
                  "name_substation" => $name_substation,
                  "name_counter"    => $name_count,
                  "date"            => $this->date_begin,
                  "time"            => $this->time_begin,
                  "id_users"        => $id_users,
                  "value"           => $this->counter_val
        ];

        $this->result = $data;
        return true;

    }
}