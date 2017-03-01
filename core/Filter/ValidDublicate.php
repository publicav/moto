<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 17.02.2017
 * Time: 23:09
 */

namespace Filter;


class ValidDublicate {
    protected $_sq;
    protected $_param;
    protected $_pdo;

    function __construct( $pdo, $sq, $param ) {
        $this->_sq = $sq;
        $this->_param = $param;
        $this->_pdo = $pdo;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function valide() {

        $res = $this->_pdo->prepare( $this->_sq );
        if ( !$res->execute( $this->_param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $id_dupl = $res->fetchAll();

        if ( !empty( $id_dupl ) ) {
            return true;
        }
        return false;

    }
}