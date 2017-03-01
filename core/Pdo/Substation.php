<?php
namespace Pdo;

class Substation {
    private $substation;

    /**
     * Substation constructor.
     * @param $pdo
     * @param $lot
     */
    function __construct( $pdo, $lot ) {
        $sq = "SELECT s.id, s.name FROM  substation AS s WHERE ( s.lots = :lot );";
        $param = [ 'lot' => $lot ];
        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            header( "HTTP/1.1 400 Bad Request", true, 400 );
            print exit_error( false, 3, $res->errorInfo()[2] );
            exit();
        }
        $substation = $res->fetchAll();
        $this->substation = $substation;
    }

    /**
     * @return mixed
     */
    function GetSubstation() {
        return $this->substation;
    }

    /**
     * @return array
     */
    function GetSubstationFilter() {
        $substationFilter[] = [ 'id' => '0', 'name' => 'Все подстанции' ];
        return array_merge( $substationFilter, $this->substation );
    }
}
