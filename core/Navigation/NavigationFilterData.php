<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 19.02.2017
 * Time: 12:40
 */

namespace Navigation;


class NavigationFilterData {
    protected $_icons = [
        'first' => '«',
        'prev'  => '&lt',
        'next'  => '&gt',
        'end'   => '»',
    ];
    protected $_title = [
        'first' => 'На первую страницу',
        'prev'  => 'Предыдущая страница',
        'next'  => 'Следующая страница',
        'end'   => 'На последнюю  страницу',
    ];
    protected $_columPage = 34;
    protected $_navigatorPage = 4;
    protected $_urlAction = '';
    protected $_position;
    protected $_total;
    protected $_cmd_arr;
    protected $_paramUrl;
    protected $_pgCurrent;
    protected $_end;

    function __construct( $position, $total, $cmd_arr ) {
        $this->_position = $position;
        $this->_total = $total;
        $this->_cmd_arr = $cmd_arr;
        if ( !is_array( $cmd_arr ) ) $this->_cmd_arr = [];
        unset( $this->_cmd_arr['st'] );
        $paramUrl = http_build_query( $this->_cmd_arr );
        if ( !empty( $paramUrl ) ) $paramUrl = '&' . $paramUrl;
        $this->_paramUrl = $paramUrl;
    }

    /**
     * @param $urlAction
     * @return $this
     */
    public function setUrlAction( $urlAction ) {
        $this->_urlAction = $urlAction;
        return $this;
    }

    public function setColumPage( $columPage ) {
        $this->_columPage = $columPage;
        return $this;
    }

    public function setNavigatorPage( $navigatorPage ) {
        $this->_navigatorPage = $navigatorPage;
        return $this;
    }

    /**
     * @param array $icons
     * @return $this
     */
    public function setIcons( $icons ) {
        $this->_icons = $icons;
        return $this;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle( $title ) {
        $this->_title = $title;
        return $this;
    }

    /**
     * @param $position
     * @param $total
     * @param $cmd_arr
     * @return NavigationFilterData
     */
    public static function init( $position, $total, $cmd_arr ) {
        return new self( $position, $total, $cmd_arr );
    }

    /**
     * @return string
     */
    public function getUrlAction() {
        return $this->_urlAction;
    }

    /**
     * @return int
     */
    public function getColumPage() {
        return $this->_columPage;
    }

    /**
     * @return string
     */
    public function getParamUrl() {
        return $this->_paramUrl;
    }

    /**
     * @return int
     */
    public function getNavigatorPage() {
        return $this->_navigatorPage;
    }

    /**
     * @return mixed
     */
    public function getPgCurrent() {
        return $this->_pgCurrent;
    }

    /**
     * @return mixed
     */
    public function getPosition() {
        return $this->_position;
    }

    /**
     * @return mixed
     */
    public function getTotal() {
        return $this->_total;
    }


    public function doNavigation() {

        $position = $this->getPosition();
        $total = $this->getTotal();
        $columPage = $this->getColumPage();

        $navigatorPage = $this->getNavigatorPage();

        if ( $position < 0 ) $position = 0;
        if ( $position > $total ) $position = ( floor( $total / $columPage ) * $columPage );

        $end = ( floor( $total / $columPage ) * $columPage );
        if ( $end == $total ) $end = $end - $columPage;
        $pgCurrent = floor( $position / $columPage ) + 1;
        $stl1 = $position - $columPage;
        $str1 = $position + $columPage;
        $pageArr = [];
        if ( $stl1 >= 0 ) {
            $pageArr[] = [ 'st' => 0, 'text' => $this->_icons['first'], 'title' => $this->_title['first'] ];
            $pageArr[] = [ 'st' => $stl1, 'text' => $this->_icons['prev'], 'title' => $this->_title['prev'] ];
        }
        for ( $i = $pgCurrent - $navigatorPage, $count = -$navigatorPage; $i <= $pgCurrent + $navigatorPage; $i++, $count++ ) {
            $stFirst = $position + $columPage * $count;
            if ( ( $stFirst >= 0 ) and ( $stFirst < $total ) ) {
                if ( $i == $pgCurrent ) {
                    if ( $total > $columPage ) {
                        $pageArr[] = [ 'st' => null, 'text' => $pgCurrent, 'title' => '' ];
                    }
                } else {
                    $pageArr[] = [ 'st' => $stFirst, 'text' => $i, 'title' => $i ];
                }
            }
        }
        if ( $str1 < $total ) {
            $pageArr[] = [ 'st' => $str1, 'text' => $this->_icons['next'], 'title' => $this->_title['next'] ];
            $pageArr[] = [ 'st' => $end, 'text' => $this->_icons['end'], 'title' => $this->_title['end'] ];
        }
        $this->_pgCurrent = $pgCurrent;
        $this->_end = $end;

        $navigation = [
            'file'     => $this->getUrlAction(),
            'paramUrl' => $this->getParamUrl(),
            'page'     => $pageArr,
        ];
        return $navigation;

    }

}