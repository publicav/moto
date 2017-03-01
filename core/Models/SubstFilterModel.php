<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 23:10
 */
namespace Models;

use Base\BaseModel;
use Pdo\Substation;

class SubstFilterModel extends BaseModel {
    public $data;
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'data' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doSubstationFilter() {
        $substationFilter = new Substation( $this->_pdo, $this->data );
        $this->result = $substationFilter->GetSubstationFilter();
        return true;
    }
}