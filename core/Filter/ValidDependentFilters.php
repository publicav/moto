<?php
/**
 * Created by PhpStorm.
 * User: mama
 * Date: 17.02.2017
 * Time: 16:44
 */

namespace Filter;

use Exception\InputException;

class ValidDependentFilters {
    protected $_lot;
    protected $_substation;
    protected $_counter;
    protected $_countData = null;
    protected $_substationData = null;
    protected $_lotData = null;
    protected $_pdo;

    function __construct( $lot, $substation, $counter ) {
        $this->_lot = $lot;
        $this->_substation = $substation;
        $this->_counter = $counter;
        $this->_pdo = \DB::getLink()->getDb();
    }

    public function valide() {
        $countData = $this->_counter();
        $substationData = $this->_substation( $countData );
        $lotData = $this->_lot( $substationData );
        return true;
    }

    protected function _counter() {
        $couner = $this->getCounter();
        $sq = "SELECT n_counter, substations, name  FROM  count  WHERE (id = :counter );";
        $param = [ 'counter' => $couner ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $countData = $res->fetchAll()[0];
        if ( empty( $countData ) ) {
            throw new InputException( 'Error input select counter' );
        }
        $this->_countData = $countData;
        return $countData;
    }

    protected function _substation( $countData ) {
        $substation = $this->getSubstation();
        if ( $countData['substations'] != $substation ) {
            throw new InputException( 'Error substation передан неверно' );
        }
        $sq = "SELECT  id, lots, name FROM  substation  WHERE (id = :substation );";
        $param = [ 'substation' => $substation ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $substationData = $res->fetchAll()[0];
        if ( empty( $substationData ) ) {
            throw new InputException( 'Error input select substation' );
        };
        $this->_substationData = $substationData;
        return $substationData;
    }

    protected function _lot( $substationData ) {
        $lot = $this->getLot();
        if ( $substationData['lots'] != $lot ) {
            throw new InputException( 'Error lot передан неверно' );
        }
        $sq = "SELECT  id,  name FROM  lots  WHERE (id = :lot );";
        $param = [ 'lot' => $lot ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $lotData = $res->fetchAll()[0];
        if ( empty( $lotData ) ) {
            throw new InputException( 'Error input select substation' );
        };
        $this->_lotData = $lotData;
        //        var_dump( $lotData, $substationData, $this->getCountData() );
        return $lotData;


    }

    public function getLot() {
        return $this->_lot;
    }

    public function getSubstation() {
        return $this->_substation;
    }

    public function getCounter() {
        return $this->_counter;
    }

    public function getLotData() {
        return $this->_lotData;
    }

    public function getSubstationData() {
        return $this->_substationData;
    }

    public function getCountData() {
        return $this->_countData;
    }

}