<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 23:10
 */
namespace Models;

use Base\BaseModel;
use Pdo\Counter;

class CounterFilterModel extends BaseModel {
    public $data;
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'data' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doCounterFilter() {
        $counterFilter = new Counter( $this->_pdo, $this->data );
        $this->result = $counterFilter->GetCounterFilter();
        return true;
    }

}