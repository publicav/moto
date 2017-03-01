<?php
namespace Pdo;

class Privelege {
    private $menu_left;
    private $visibly = 0;
    private $_pdo;
    protected $_id;

    function __construct( $id ) {
        $this->_pdo = \db::getLink()->getDb();
        $sq = "SELECT id,id_menu, visibly FROM tables_priv_new WHERE (id_users = :id )";
        $param = [ 'id' => $id ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->priv = $res->fetchAll();
        $this->_id = $id;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    function getMenuLeft() {
        $sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );        }
        while ( $row = $res->fetch() ) {
            for ( $i = 0; $i < SizeOf( $this->priv ); $i++ ) {
                if ( ( $row['id_menu'] == $this->priv[ $i ]['id_menu'] ) AND ( $this->priv[ $i ]['visibly'] == 1 ) ) {
                    $this->menu_left[] = $row;
                    break;
                }
            }
        }

        return $this->menu_left;
    }

    /**
     * @param string $Page_Name
     * @return int $visibly
     */
    function GetVisiblyFilter( $Page_Name ) {
        for ( $i = 0; $i < SizeOf( $this->menu_left ); $i++ ) {
            if ( $this->menu_left[ $i ]['id_a'] == $Page_Name ) $this->visibly = 1;
        }
        return $this->visibly;
    }

    /**
     * @return array
     */

    public function getPriv() {
        return $this->priv;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->_id;
    }
}
