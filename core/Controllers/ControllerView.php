<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.02.2017
 * Time: 21:36
 */

namespace Controllers;


use Base\Conroller;

class ControllerView extends Conroller {
    public function actionIndex() {
        // TODO: Implement actionIndex() method.
        $this->_view->setLayout( $this->_route->getLayout( 'view_v' ) );
        $this->_view->render( $this->_route->getViewPath(), '' );

    }

    public function actionBlank() {
        // TODO: Implement actionBlank() method.
        $this->_view->setLayout( $this->_route->getLayout( 'view_v' ) );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionCalcGroup() {
        $this->_view->setLayout( $this->_route->getLayout( 'view_v' ) );
        $this->_view->setJs( [
            'js/ui/minified/jquery-ui.min.js',
            'js/view-main.js',
            'js/view-table.js',
            'js/datatables.min.js',
            'js/date-euro.js',
            'js/ui/minified/jquery.ui.datepicker-ru.min.js',

        ] );
        $this->_view->setCss( [
            'css/datatables.min.css',
            'css/jquery-ui.min.css',

        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );

    }
    public function actionChartGroup(){
        $this->_view->setLayout( $this->_route->getLayout( 'view_v' ) );
        $this->_view->setJs( [
            'js/ui/minified/jquery-ui.min.js',
            'js/ui/minified/jquery.ui.datepicker-ru.min.js',
            'js/view-main.js',
            'js/view-chart.js',
            'js/highcharts.js',
            'js/modules/exporting.js',
        ] );
        $this->_view->setCss( [
            'css/jquery-ui.min.css',
//            '${demo.css}'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );

    }

}