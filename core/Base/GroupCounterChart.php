<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.02.2017
 * Time: 23:32
 */

namespace Base;
//use \Date\DivisionDay;
//use \Pdo\GroupCounterData;


class GroupCounterChart extends GroupCounterCalc {
    protected function _bustDays() {
        $dtHigh = new \DateTime( $this->_dateHigh );
        $dtCurrent = new \DateTime( $this->_dateLow . ' 00:00:00' );
        //        var_dump( $dtCurrent, $dtHigh, $this->_dateLow );
        while ( $dtCurrent <= $dtHigh ) {
            $timeStamp = $dtCurrent->getTimestamp();
            $_calc = $this->_calc( $timeStamp );
            $_calcD['date'][] = $dtCurrent->format( 'd-m-Y' );
            foreach ( $_calc as $key => $value1 ) {
                $_calcD[$key][] = round( $value1, $this->_round );
            }
            $this->_calcData = $_calcD;

            $dtCurrent->add( new \DateInterval( 'P1D' ) );
        }
//        var_dump($this->_calcData);
    }

    public function getxAxis(){
        return  $this->getCalcData()['date'];

//        $legend = $this->_dataGroup->getData();
//        $calcData = $this->getCalcData();

    }
    public function getOutputChartData(){
        $legend = $this->getLegend();
        $calcData = $this->getCalcData();
        $chartData =[];
        $count = 0;
        foreach ( $legend as $key => $value ) {
            $chartData[] = [ 'name' => $value['name'], 'data' => $calcData[ $count ] ];
            $count++;
        }
        return $chartData;

    }

}