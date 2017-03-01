<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.01.2017
 * Time: 6:47
 */

//namespace db;


class db {
    protected $_config;
    protected static $_link = null;
    protected static $_pdo = null;

    private $_db;

    /**
     * db constructor.
     */
    public function __construct(){
        if( !file_exists(__DIR__  . "/config/db.conf.php") ) {
            throw new \Exception('Config db not found!');
        }

        $this->_config = require_once __DIR__  . "/config/db.conf.php";
        $dsn = 'mysql:host=' . $this->_config['host'] . ';dbname=' . $this->_config['dbname'] . ';charset=' . $this->_config['charset'];
        $this->_db = new \PDO( $dsn,
                            $this->_config['user'],
                            $this->_config['pass'],
                            $this->_config['optimization']
        );
    }

    /**
     * @return null|db
     */
    public static function getLink(){
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
        return self::$_link;
    }

    /**
     * @return PDO
     */
    public function getDb(){
        return $this->_db;
    }
}