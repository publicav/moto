<?php
namespace Date;

class DivisionDay {
    public $minuteBefore = 0;
    public $minuteAfter = 0;
    private $_dt1;

    /**
     * DivisionDay constructor.
     * @param $dt1
     */
    function __construct( $dt1 ) {
        $dt_tek = new \DateTime( $dt1 );
        $datetime1 = new \DateTime( $dt1 );
        $this->_dt1 = $datetime1;
        $datetime2 = new \DateTime( $dt_tek->format( 'Y-m-d' ) );
        $interval = $datetime1->diff( $datetime2 );

        $this->minuteBefore = $interval->h * 60 + $interval->i;
        $this->minuteAfter = 1440 - $this->minuteBefore;
    }

    /**
     * @return int
     */
    public function getAfter() {
        return $this->minuteAfter;
    }

    /**
     * @return int
     */
    public function getBefore() {
        return $this->minuteBefore;
    }

    public function is_day( $timeStumpDay ) {
        $dtInput = date( 'Y-m-d h:i:s', $timeStumpDay );
        $dt = new \DateTime( $dtInput );

        $interval = $this->_dt1->diff( $dt );
        $diff = $interval->h * 60 + $interval->i;
        if ( $diff > $this->getBefore() ) {
            return false;
        }
        return true;
    }

    public function rangeTimeLow( $dtLow ) {
        $DateTime1 = new \DateTime( $dtLow );
        $interval = $this->_dt1->diff( $DateTime1 );
        return $interval->h * 60 + $interval->i;
    }

    public function rangeTimeHigh( $dtHigh ) {
        $DateTime2 = new \DateTime( $dtHigh );
        $interval = $DateTime2->diff( $this->_dt1 );
        return $interval->h * 60 + $interval->i;
    }

}
