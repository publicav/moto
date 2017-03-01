<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 27.02.2017
 * Time: 12:34
 */

namespace Models;


use Base\BaseModel;
use Base\GroupCounterCalc;
use Date\RangeMonthSql;
use Navigation\NavigationCalc;
use Pdo\CounterData;
use Pdo\GetCounts;


class CalculationCounterModel extends BaseModel {
    public $id_lot;
    public $id_sub;
    public $id_counter;
    public $date_b;
    public $date_e;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id_lot'     => [ 'aboveZerroInt', ],
            'id_sub'     => [ 'aboveZerroInt', ],
            'id_counter' => [ 'aboveZerroInt', ],
            'date_b'     => [ 'isDate', ],
            'date_e'     => [ 'isDate', ],
        ];
    }

    public function doCalculationCounter() {

        $id_counter = $this->id_counter;
        $date_b = $this->date_b;
        $rangeDate = RangeMonthSql::init( $date_b, '' )->DoRangeDate();
        $dt1 = $rangeDate->getDateFirst();
        $dt2 = $rangeDate->getDateLast();

        $navig = [
            'id_counter' => $id_counter,
        ];

        $navigationcalc = new NavigationCalc( 'calc_count.php', $dt1, $navig );
        $navigationcalc->classHTML = [ 'navigator', 'pagelink', 'pagecurrent' ];
        $navigator = $navigationcalc->getNavigator();


        $dtPresent = new \DateTime();

        $dtLow = new \DateTime( $this->_config['DATE_BEGIN'] );
        $dtHigh = new \DateTime( $dt2 );

        $dtPresent->add( new \DateInterval( 'P1M' ) );

        if ( ( $id_counter <= 0 ) or ( ( $dtHigh > $dtPresent ) or ( $dtHigh < $dtLow ) ) ) {
            $this->result = [
                'success'   => true,
                'id_error'  => 0,
                'data'      => [],
                'navigator' => $navigator,
            ];
            return false;
        }

        $dataCounter = CounterData::init( $id_counter );
        $dataCounter->queryGroup( $dt1, $dt2 );

        $getCount = new GetCounts( [ 'id' => $id_counter ] );
        $name_counter = $getCount->getName();

        $calcGroup = new GroupCounterCalc( $dataCounter, $dt1, $dt2 );
        $calcGroup->calc();


        $this->result = [
            'success'   => true,
            'id_error'  => 0,
            'nameGroup' => $calcGroup->getNameGroup(),
            'title'     => $name_counter,
            'Data'      => $calcGroup->getCalcData(),
            'navigator' => $navigator,
        ];
        return true;

    }
}