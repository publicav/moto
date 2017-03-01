<?php
namespace Pdo;

class Counter {
    protected $param;
    protected $counter;

    function __construct( $pdo, $substation ) {
        $sq = "SELECT c.id, c.name FROM  count AS c WHERE ( c.substations = :substation );";
        $param = [ 'substation' => $substation ];
        $res = $pdo->prepare( $sq );
        if ( $res->execute( $param ) ) {
            $this->counter = $res->fetchAll();
        } else {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
    }

    function GetCounter() {
        return $this->counter;
    }

    function GetCounterFilter() {
        $counterFilter[] = [ 'id' => '0', 'name' => 'Все ячейки' ];
        return array_merge( $counterFilter, $this->counter );
    }
}
