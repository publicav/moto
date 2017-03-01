<?php
/**
 * Created by PhpStorm.
 * User: mama
 * Date: 16.02.2017
 * Time: 16:50
 */

namespace Pdo;


class GetMenuLeft {
    function __construct() {
        $pdo = \Db::getLink()->getDb();
        $sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu, m.name AS name, m.url AS url FROM menu_left AS m;";
        if ( !$res = $pdo->query( $sq ) ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
        $this->_MenuLeftData = $res->fetchAll();
    }

    /**
     * @return array
     */
    public function getMenuLeftData() {
        return $this->_MenuLeftData;
    }
}