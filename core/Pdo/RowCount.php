<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 20.02.2017
 * Time: 9:32
 */

namespace Pdo;


class RowCount {
    protected $_pdo;
    protected $_sql;
    protected $_param;
    protected $_rowCount;

    function __construct( $sql, $param ) {
        $this->_pdo = \DB::getLink()->getDb();
        $this->_sql = $sql;
        $this->_param = $param;
    }

    public static function init( $sql, $param ) {
        return new self( $sql, $param );
    }

    public function doRowCount() {
//        var_dump( $this->_sql );
        $res = $this->_pdo->prepare( $this->_sql );
        if ( !$res->execute( $this->_param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->_rowCount = $res->rowCount();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRowCount() {
        return $this->_rowCount;
    }
}