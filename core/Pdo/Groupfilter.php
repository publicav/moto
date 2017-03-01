<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.02.2017
 * Time: 22:52
 */

namespace Pdo;


class GroupFilter {
    private $_groupsFilter;

    private static $_link;

    function __construct() {
        $pdo = \db::getLink()->getDb();
        $sq = "SELECT id, name FROM  name_group_counters ORDER BY sort;";
        $res = $pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new Exception( 'Bad Request' . $res->errorInfo()[2], '400' );
        }
        $this->_groupsFilter = $res->fetchAll();
    }

    public static function init() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        return self::$_link;
    }
    public function render() {
        $groupHTML = '';
        $countLots = count( $this->_groupsFilter );
        for ( $i = 0; $i < $countLots; $i++ ) {
            $groupHTML .= "<option value=\"{$this->_groupsFilter[$i]['id']}\">{$this->_groupsFilter[$i]['name']}</option>";
        }
        echo $groupHTML;
    }



}