<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:10
 */

namespace Base;

use Navigation\Route;
use Pdo\GetNamePage;

abstract class  Conroller {
    public $_view;
    public $_route;
    public $_auth;

    function __construct() {
        $this->_view = new View();
        $this->_route = Route::init();
        $this->_auth = $this->_route->getAuthorization();
        $this->_view->setAuth( $this->_auth );
        $this->_view->setLayout( $this->_route->getLayout( 'main' ) );
        $this->_view->setHeadUrl( GetNamePage::getConfAll( $this->_route->getFileName(), $this->_route->getLangv() ) );
    }

    abstract public function actionIndex();

    abstract public function actionBlank();
}