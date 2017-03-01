<?php
namespace Date;

class PeriodDay {
    private $dt1, $dt2;
    public $interval;
    public $day = [];
    public $round = 3;

    /**
     * PeriodDay constructor.
     * @param $dt1
     * @param $dt2
     * @param $diffMinuteVal
     * @param $name_counter
     */
    function __construct( $dt1, $dt2, $diffMinuteVal, $name_counter ) {
        $this->datetime1 = new \DateTime( $dt1 );
        $this->datetime2 = new \DateTime( $dt2 );
        $this->dt1 = $this->datetime1->format( 'd' );

        $this->datetime2->add( new \DateInterval( 'P1D' ) );

        while ( $this->datetime2->format( 'd' ) != $this->dt1 ) {
            $this->day[] = [
                'name_counter' => $name_counter,
                'date'         => $this->datetime2->format( 'd-m-Y' ),
                'rare'         => round( ( $diffMinuteVal * 1400 ), $this->round )
            ];
            $this->datetime2->add( new \DateInterval( 'P1D' ) );
        }
    }
}

