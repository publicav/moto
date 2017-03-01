<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 20.02.2017
 * Time: 6:48
 */

namespace Date;


class RangeTimeSql extends RangeMonthSql {

    /**
     * @param $fieldSqlName
     * @return $this
     */
    public function doRange( $fieldSqlName ) {
        $date_b = $this->_dt1;
        $date_e = $this->_dt2;
//        var_dump($date_b,$date_e);
        if ( $date_e == '' ) $date_e = $date_b;
        if ( $date_b == '' ) $date_b = $date_e;

        if ( ( \DateTime::createFromFormat( 'Y-m-d', $date_b ) ) and ( \DateTime::createFromFormat( 'Y-m-d', $date_e ) ) ) {
            $this->dtLow = new \DateTime( $date_b );
            $this->dtHigh = new \DateTime( $date_e );
            $this->_sql = " AND $fieldSqlName  BETWEEN  '{$this->getDateLow()}' AND '{$this->getDateHigh()}'";
        } else $this->_sql = '';
        return $this;
    }

    public static function init( $dt1, $dt2 ) {
        return new self( $dt1, $dt2 );
    }

}