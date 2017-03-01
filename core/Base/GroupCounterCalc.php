<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 20:53
 */

namespace Base;

use Date\DivisionDay;
use Pdo\GroupCounterData;

class GroupCounterCalc {
    const MAX_ITERACION = 11;
    const MINUTE_DAY = 1440;
    const LOW_MIN = 20;
    protected $_dataGroup;
    protected $_dateLow, $_dateHigh;
    private $_sortData;
    protected $_calcData;
    protected $_round = 3;

    public function __construct( GroupCounterData $dataGroup, $dateLow, $dateHigh ) {
        $this->_dateLow = $dateLow;
        $this->_dateHigh = $dateHigh;
        $this->_dataGroup = $dataGroup;
    }

    public function calc() {
        $this->_sortArray();
        $this->_bustDays();
    }

    /**
     * @return mixed
     */
    public function getInputSqlData() {
        return $this->_dataGroup->getSqlData();
    }

    /**
     * round  Округление результата до нужной точности
     * @param int $round
     */
    public function setRound( $round ) {
        $this->_round = $round;
    }

    /**
     * @return mixed
     */
    public function getNameGroup() {
        return $this->_dataGroup->getNameGroup();
    }

    public function getTitle() {
        $legend = $this->getLegend();
        $title[] = [ 'sTitle' => 'Время' ];
        foreach ( $legend as $key => $value ) $title[] = [ 'sTitle' => $value['name'] ];
        $title[] = [ 'sTitle' => 'Сумма' ];
        return $title;
    }

    /**
     * @return mixed
     */
    public function getSortData() {
        return $this->_sortData;
    }

    /**
     * @return mixed
     */
    public function getLegend() {
        return $this->_dataGroup->getData();
    }

    /**
     * @return mixed
     */
    public function getCalcData() {
        return $this->_calcData;
    }

    private function _sortArray() {
        $sortData = [];
        $inputSqlData = $this->getInputSqlData();
        $countInputData = count( $inputSqlData );
        for ( $i = 0; $i < $countInputData; $i++ ) {
            $row = $inputSqlData[ $i ];
            $counter = $row['id_counter'];
            if ( !array_key_exists( $counter, $sortData ) ) $sortData[ $counter ] = [];
            unset( $row['id_counter'] );
            $sortData[ $counter ][] = $row;
        }
        ksort( $sortData );
        $this->_sortData = $sortData;
        //                        var_dump( $this->_sortData );

    }

    protected function _bustDays() {
        $dtHigh = new \DateTime( $this->_dateHigh );
        $dtCurrent = new \DateTime( $this->_dateLow . ' 00:00:00' );
        //        var_dump( $dtCurrent, $dtHigh, $this->_dateLow );
        while ( $dtCurrent <= $dtHigh ) {
            $timeStamp = $dtCurrent->getTimestamp();
            $_calc = $this->_calc( $timeStamp );
            $_calcD = [];
            $_calcD[] = $dtCurrent->format( 'd-m-Y' );
            foreach ( $_calc as $key => $value1 ) {
                $_calcD[] = round( $value1, $this->_round );
            }
            $this->_calcData[] = $_calcD;
            $dtCurrent->add( new \DateInterval( 'P1D' ) );
        }
    }

    private function _bisectionCounters( $timeStamp ) {
        $retIndex = [];
        foreach ( $this->_sortData as $key => $sortDataCount ) {
            $retIndex[ $key ] = $this->_bisection( $timeStamp, $sortDataCount );
        }
        return $retIndex;
    }

    private function _bisection( $timeStamp, $counter ) {
        $index = count( $counter ) - 1;
        //        var_dump( $counter[ $index ] );
        if ( $index <= 2 ) {
            return [ 'position' => 1, 'indexLow' => null, 'index' => null, 'indexHigh' => null ];
        }
        if ( $timeStamp >= $counter[ $index ]['date_second'] ) {
            return [ 'position' => 2, 'indexLow' => $index - 1, 'index' => 0, 'indexHigh' => $index ];
        }
        if ( $timeStamp <= $counter[0]['date_second'] ) {
            return [ 'position' => 3, 'indexLow' => 0, 'index' => 0, 'indexHigh' => 1 ];
        }
        $index = (int)( $index / 2 );
        $position = $index;
        $count = 0;
        while ( 1 ) {
            $timeInd = $counter[ $position ]['date_second'];
            $timeInd1 = $counter[ $position - 1 ]['date_second'];

            if ( ( $timeStamp <= $timeInd ) and ( $timeStamp >= $timeInd1 ) ) {
                break;
            }
            $index = (int)( $index / 2 );
            if ( $timeStamp <= $timeInd ) {
                $position = $position - $index;
            } else {
                $position = $position + $index;
            }
            if ( $count >= self::MAX_ITERACION ) break;
            $count++;
        }
        return [ 'position' => 0, 'indexLow' => $position - 1, 'index' => $position, 'indexHigh' => $position + 1 ];
    }

    protected function _calc( $timeStamp ) {
        $powerAll = 0;

        $indexAllArray = $this->_bisectionCounters( $timeStamp );

        $keys = array_keys( $this->_sortData );
        $legend = $this->getLegend();
        foreach ( $keys as $key ) {
            $indexArr = $indexAllArray[ $key ];
            //            var_dump( $indexArr );
            switch ( $indexArr['position'] ) {
                case 0:
                    $_power = $this->_powerDay( $timeStamp, $indexArr, $key );
                    break;
                case 1:
                    $_power = 0;
                    break;
                case 2:
                    $_power = $this->_powerDayAbove( $indexArr, $key );
                    break;
                case 3:
                    $_power = $this->_powerDayBelow( $indexArr, $key );;
                    break;
                default:
                    $_power = 0;
            }
            $power[] = $_power * $legend[ $key ]['coefficient'];
            $powerAll = $powerAll + $_power * $legend[ $key ]['coefficient'];

        }
        $power[] = $powerAll;
        //        var_dump($power);
        return $power;
    }

    protected function _powerDay( $timeStamp, $indexArr, $key ) {

        $countLow = $this->_sortData[ $key ][ $indexArr['indexLow'] ];
        $countCurrent = $this->_sortData[ $key ][ $indexArr['index'] ];
        $countHigh = $this->_sortData[ $key ][ $indexArr['indexHigh'] ];

        $valueLow = $countLow['value'];
        $valueCurrent = $countCurrent['value'];
        $valuueHigh = $countHigh['value'];

        $timeLow = $countLow['date_second'];
        $timeCurrent = $countCurrent['date_second'];
        $timeHigh = $countHigh['date_second'];

        $coeff1 = $this->_dataGroup->getCoeffPower( $key, $countCurrent['n_counter'] );
        $coeff2 = $this->_dataGroup->getCoeffPower( $key, $countHigh['n_counter'] );

        //todo-me добавить  coeff2 если будет переход на другой счетчик. Пока переход на другой счетчик не релизован
        //todo-me добавить переход счётчика через ноль

        $DivisionDay = new DivisionDay( $countCurrent['dt1'] );

        if ( $DivisionDay->is_day( $timeStamp ) ) {
            $valueCurrent1 = $valueCurrent;
            $valuueHigh1 = $valuueHigh;
            $diffTime1 = round( ( $timeCurrent - $timeLow ) / 60 );
            $diffTime2 = round( ( $timeHigh - $timeCurrent ) / 60 );

            if ( ( $valueLow > $valueCurrent ) and ( $valueCurrent < self::LOW_MIN ) ) {
                $pw = strlen( floor( $valueLow ) );
                $maxNumb = 10 ** $pw;
                $diffNumb = $maxNumb - $valueLow;
                if ( $diffNumb < self::LOW_MIN ) {
                    $valueCurrent1 = $valueCurrent + $maxNumb;
                }

            }
            if ( ( $valueCurrent > $valuueHigh ) and ( $valuueHigh < self::LOW_MIN ) ) {
                $pw = strlen( floor( $valueCurrent ) );
                $maxNumb = 10 ** $pw;
                $diffNumb = $maxNumb - $valueCurrent;
                if ( $diffNumb < self::LOW_MIN ) {
                    $valuueHigh1 = $valuueHigh + $maxNumb;
                }
            }

            $diffValue1 = ( $valueCurrent1 - $valueLow ) * $coeff1;
            $diffValue2 = ( $valuueHigh1 - $valueCurrent ) * $coeff2;

            $diffPower1 = $diffValue1 / $diffTime1;
            $diffPower2 = $diffValue2 / $diffTime2;

            $power = $diffPower1 * $DivisionDay->getBefore() + $diffPower2 * $DivisionDay->getAfter();

        } else {
            $diffTime1 = round( ( $timeCurrent - $timeLow ) / 60 );
            $diffValue1 = ( $valueCurrent - $valueLow ) * $coeff1;
            $diffPower1 = $diffValue1 / $diffTime1;
            $power = $diffPower1 * self::MINUTE_DAY;

        }
        return $power;
    }

    private function _powerDayAbove( $indexArr, $key ) {
        $indexLow = $indexArr['indexLow'];
        $countLow = $this->_sortData[ $key ][ $indexLow ];
        $indexHigh = $indexArr['indexHigh'];
        $countHigh = $this->_sortData[ $key ][ $indexHigh ];
        $coeff1 = $this->_dataGroup->getCoeffPower( $key, $countHigh['n_counter'] );

        $valueLow = $countLow['value'];
        $valuueHigh = $countHigh['value'];
        $valuueHigh1 = $valuueHigh;
        if ( ( $valueLow > $valuueHigh ) and ( $valuueHigh < self::LOW_MIN ) ) {
            $pw = strlen( floor( $valueLow ) );
            $maxNumb = 10 ** $pw;
            $diffNumb = $maxNumb - $valueLow;
            if ( $diffNumb < self::LOW_MIN ) {
                $valuueHigh1 = $valuueHigh + $maxNumb;
            }
        }

        $diffTime1 = round( ( $countHigh['date_second'] - $countLow['date_second'] ) / 60 );
        $diffValue1 = ( $valuueHigh1 - $valueLow ) * $coeff1;
        $diffPower1 = $diffValue1 / $diffTime1;
        $power = $diffPower1 * self::MINUTE_DAY;

        return $power;
    }

    private function _powerDayBelow( $indexArr, $key ) {
        $indexLow = $indexArr['indexLow'];
        $countLow = $this->_sortData[ $key ][ $indexLow ];
        $indexHigh = $indexArr['indexHigh'];
        $countHigh = $this->_sortData[ $key ][ $indexHigh ];
        $coeff1 = $this->_dataGroup->getCoeffPower( $key, $countHigh['n_counter'] );

        $valueLow = $countLow['value'];
        $valuueHigh = $countHigh['value'];
        $valuueHigh1 = $valuueHigh;


        if ( ( $valueLow > $valuueHigh ) and ( $valuueHigh < self::LOW_MIN ) ) {
            $pw = strlen( floor( $valueLow ) );
            $maxNumb = 10 ** $pw;
            $diffNumb = $maxNumb - $valueLow;
            if ( $diffNumb < self::LOW_MIN ) {
                $valuueHigh1 = $valuueHigh + $maxNumb;
            }
        }

        $diffTime1 = round( ( $countHigh['date_second'] - $countLow['date_second'] ) / 60 );
        $diffValue1 = ( $valuueHigh1 - $valueLow ) * $coeff1;
        $diffPower1 = $diffValue1 / $diffTime1;
        $power = $diffPower1 * self::MINUTE_DAY;

        return $power;
    }

}