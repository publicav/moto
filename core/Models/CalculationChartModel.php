<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 27.02.2017
 * Time: 19:16
 */

namespace Models;


use Base\BaseModel;
use Base\GroupCounterChart;
use Pdo\GroupCounterData;

class CalculationChartModel extends BaseModel {
    public $group;
    public $date_b;
    public $date_e;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'group'  => [ 'required', 'aboveZerroInt' ],
            'date_b' => [ 'isDate' ],
            'date_e' => [ 'isDate' ],
        ];
    }

    public function doCalculationChart() {

        $dt = new \DateTime();
        if ( empty( $this->date_b ) ) {
            $this->date_b = $dt->format( 'Y-m-01' );
            $this->date_e = $dt->format( 'Y-m-d' );

        } elseif ( empty( $this->date_e ) ) {
            $this->date_e = $dt->format( 'Y-m-d' );
        }

        $dateLow = $this->date_b;
        $dateHigh = $this->date_e;
        $numberGroup = $this->group;

        $dataGroup = GroupCounterData::init( $numberGroup );
        $dataGroup->queryGroup( $dateLow, $dateHigh );

        $chartGroup = new GroupCounterChart( $dataGroup, $dateLow, $dateHigh );
        $chartGroup->calc();

        $this->result = [
            'success'    => true,
            'id_error'   => 0,
            'length'     => count( $chartGroup->getxAxis() ),
            'nameGroup'  => $chartGroup->getNameGroup(),
            'categories' => $chartGroup->getxAxis(),
            'calcData'   => $chartGroup->getOutputChartData(),
        ];
        return true;
    }

}