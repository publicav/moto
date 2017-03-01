<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.01.2017
 * Time: 18:42
 */

namespace Pdo;

use Exception\BadRequestException;

class GetCoeffPower {
    private $res, $koefPower;
    private $_pdo;


    function __construct( $param ) {
        $this->_pdo = \db::getLink()->getDb();
        $sq = "SELECT x.koef, x.n_counter  FROM	xchange AS x WHERE (x.id_counter = :id) AND (x.n_counter = :n_counter);";
        $this->res = $this->_pdo->prepare( $sq );
        if ( !$this->res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        while ( $row = $this->res->fetch() ) $this->koefPower[ $row['n_counter'] ] = $row['koef'];

        if ( empty( $this->koefPower ) ) {
            throw new BadRequestException( 'СoefPower not found!' );
        }

    }

    /**
     * koefPower для одной ячейки за всё время
     * @return array
     */
    public function getKoefPowerId() {
        return $this->koefPower;
    }

}