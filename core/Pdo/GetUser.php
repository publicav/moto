<?php
namespace Pdo;

class GetUser {
    protected $_user = null;
    private static $_link;
    private $_pdo;

    /**
     * GetUser constructor.
     * @param $id
     * @throws \Exception
     */
    function __construct( $id ) {
//        if ( !is_null( $id ) ) return;
        $this->_pdo = \db::getLink()->getDb();
        $sq = "SELECT name, family FROM users_c WHERE (id= :id );";
        $param = [ 'id' => $id ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $res->errorInfo()[2], '400' );
        }
        $user_a = $res->fetchAll();
        if ( !empty( $user_a ) ) $this->_user = $user_a[0];
    }


    /**
     * @param $id
     * @return GetUser
     */
    public static function GetUser( $id ) {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self( $id );
        }
        return self::$_link;
    }

    public function render() {
        if ( !is_null( $this->_user ) )
            echo "<div class=\"user\"><div class=\"title_user\">Вы зашли как:</div>{$this->_user['name']} {$this->_user['family']}</div>";
    }
}
