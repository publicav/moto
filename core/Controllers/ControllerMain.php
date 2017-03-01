<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:16
 */

namespace Controllers;


use Base\Conroller;
use Pdo\Privelege;

class ControllerMain extends Conroller {
    public function actionIndex() {
        // TODO: Implement actionIndex() method.
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionBlank() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $this->_view->render( $this->_route->getBlankViewPath(), '' );
    }

    public function actionHelp() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionLoad_forms() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/user.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionAddNumberSap() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/autocomplete.js',
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

}