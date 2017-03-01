<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.02.2017
 * Time: 20:12
 */

namespace Models;


use Base\BaseModel;
use Date\RangeTimeSql;
use Navigation\NavigationFilterData;
use Pdo\RowCount;

class FilterValueModel extends BaseModel {
    public $st;
    public $id_lot;
    public $id_sub;
    public $id_counter;
    public $date_b;
    public $date_e;


    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'st'         => [ 'aboveZerroInt', ],
            'id_lot'     => [ 'aboveZerroInt', ],
            'id_sub'     => [ 'aboveZerroInt', ],
            'id_counter' => [ 'aboveZerroInt', ],
            'date_b'     => [ 'isDate', ],
            'date_e'     => [ 'isDate', ],

        ];
    }

    public function doFilterValue() {
        $select = 1;
        $position_in = $this->st;
        $id_lot = $this->id_lot;
        $id_sub = $this->id_sub;
        $id_counter = $this->id_counter;

        if ( $id_lot > 0 ) $select = 2;
        if ( $id_sub > 0 ) $select = 3;
        if ( $id_counter > 0 ) $select = 4;

        $date_b = $this->date_b;
        $date_e = $this->date_e;
        $dtRangeSql = RangeTimeSql::init( $date_b, $date_e )->doRange( 'date_create' )->getSQL();

        $filter = [];
        $paramNrange = [];
        $param = [ 'position_in' => $position_in,
                   'total_col'   => $this->_config['PAGE_COUNTER']
        ];

        switch ( $select ) {
            case 1:
                $filterSql = '';
                break;
            case 2:
                $filterSql = ' AND (lot.id = :id_lot)';
                $paramNrange = [ 'id_lot' => $id_lot ];
                $param['id_lot'] = $id_lot;
                $filter = [ 'id_lot' => $id_lot ];
                break;
            case 3:
                $filterSql = ' AND (sub.id = :id_sub)';
                $paramNrange = [ 'id_sub' => $id_sub ];
                $param['id_sub'] = $id_sub;
                $filter = [
                    'id_lot' => $id_lot,
                    'id_sub' => $id_sub
                ];

                break;
            case 4:
                $filterSql = ' AND (cnt.id = :id_counter)';
                $paramNrange = [ 'id_counter' => $id_counter ];
                $param['id_counter'] = $id_counter;
                $filter = [
                    'id_lot' => $id_lot,
                    'id_sub' => $id_sub,
                    'id_counter' => $id_counter
                ];
                break;

            default:
                $filterSql = '';
        }
        $sqlNumberRecords = "SELECT main.id 
                     FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
                     WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) 
                     $filterSql $dtRangeSql;
                     ";

        $total = RowCount::init( $sqlNumberRecords, $paramNrange )->doRowCount()->getRowCount();

        $sq = "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, 
                      main.value AS value, sub.name AS substation, lot.name AS lot, 
                      concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND 
				      (main.id_users = users.id)  
				      $filterSql $dtRangeSql
				ORDER by date_create
				LIMIT :position_in, :total_col;
      ";

        //        $this->_pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        $this->_pdo->setAttribute( 20, false );
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }

        $counter = [];
        while ( $row = $res->fetch() ) {
            $keyId = 'c' . $row['id'];
            $counter[ $keyId ] = $row;
        }
        $navigationData = NavigationFilterData::init( $position_in, $total, $filter )->
                          setColumPage( 35 )->setNavigatorPage( 5 )->doNavigation();

        $this->result = [
            'success'        => true,
            'id_error'       => 0,
            'data'           => $counter,
            'navigationData' => $navigationData,
        ];
        return true;

    }

}