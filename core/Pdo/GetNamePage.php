<?php
namespace Pdo;

class GetNamePage {
    private $_conf_h;
    protected static $_link = null;


    function __construct( $pageName, $langvige ) {
        $pdo = \db::getLink()->getDb();
        $sq = "SELECT m.title, m.meta_k, m.meta_d FROM adm_main_struct AS m WHERE (m.name = :page_name) AND (id_lang = :id_lang);";
        $param = [ 'page_name' => $pageName, 'id_lang' => $langvige ];
        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( 'Bad Request - ' . $res->errorInfo()[2], '400' );
        }
        $conf_h = $res->fetchAll();
        if ( empty( $conf_h ) ) $conf_h[0] = [ 'title' => '', 'meta_d' => '', 'meta_k' => '' ];
        $this->_conf_h = $conf_h[0];
    }

    /**
     * @param $pageName
     * @param $langvige
     * @return array
     */
    public static function getConfAll( $pageName, $langvige ) {
        if ( is_null( self::$_link ) ) self::$_link = new self( $pageName, $langvige );
        return self::$_link->_conf_h;
    }

}
