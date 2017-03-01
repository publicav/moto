<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.2017
 * Time: 18:19
 */

namespace Pdo;


class GetAllUsers {
    protected $_user_all;

    function __construct() {
        $pdo = \db::getLink()->getDb();
        $sq = "SELECT id, users, name, family FROM users_c WHERE  (ring > 0) ORDER BY id DESC;";
        $res = $pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new Exception( 'Bad Request' . $res->errorInfo()[2], '400' );
        }

        $this->_user_all = $res->fetchAll();

    }

    /**
     * @return array
     */
    public function getUserAll() {
        return $this->_user_all;
    }

}