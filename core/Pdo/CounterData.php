<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 20.02.2017
 * Time: 19:37
 */

namespace Pdo;


class CounterData extends GroupCounterData {
    function __construct( $numberCounter ) {
        $this->_pdo = \db::getLink()->getDb();
        $this->_idGroup = $numberCounter;
        $this->qIdCell();
        $this->qDataCell();
        $this->qCoeeffPower();
        $this->creteInputData();

    }

    public static function init( $numberCounter ) {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self( $numberCounter );
        }
        return self::$_link;
    }

    protected function qIdCell() {
        $this->_idCells[] = [ 'id' => $this->_idGroup, 'coefficient' => 1 ];
    }


}