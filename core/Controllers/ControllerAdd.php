<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 27.02.2017
 * Time: 19:42
 */

namespace Controllers;


use Base\Conroller;
use Pdo\Privelege;

class ControllerAdd extends Conroller {
    public function actionIndex() {
        // TODO: Implement actionIndex() method.
        $this->_view->setLayout( $this->_route->getLayout( 'add_main' ) );
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/jquery.maskedinput.min.js',
            'js/add_counts.js',
        ] );

        $this->_view->render( $this->_route->getViewPath(), '' );

    }

    public function actionBlank() {
        // TODO: Implement actionBlank() method.

        $this->_view->setLayout( $this->_route->getLayout( 'add_main' ) );
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $this->_view->setJs( [
            'js/jquery.maskedinput.min.js',
            'js/add_counts.js',
        ] );

        $this->_view->render( $this->_route->getBlankViewPath(), '' );

    }

}