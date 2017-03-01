<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2017
 * Time: 18:25
 */

namespace Base;


class View {
    protected $_baseDir = __DIR__ . '';
    protected $_title, $_MetaK, $_MetaD;
    protected $_layout;
    protected $_FileMainMenu, $_leftMenu;
    protected $_auth = null;
    protected $_user;
    protected $_js = [];
    protected $_css = [];
    protected $_seo = [];

    public function render( $tplName, $data ) {
        include $this->_layout;
    }
    /**
     * @param mixed $mainMenu
     */
    public function setFileMainMenu( $mainMenu ) {
        $this->_FileMainMenu = $mainMenu;
    }

    public function setLayout( $pathLauout ) {
        $this->_layout = $pathLauout;
    }

    /**
     * @param $confArray
     */
    public function setHeadUrl( $confArray ) {
        $this->_title = $confArray['title'];
        $this->_MetaK = $confArray['meta_k'];
        $this->_MetaD = $confArray['meta_d'];
    }


    /**
     * @param mixed $auth
     */
    public function setAuth( $auth ) {
        $this->_auth = $auth;
    }

    /**
     * @return null
     */
    public function getAuth() {
        return $this->_auth;
    }

    /**
     * @param mixed $user
     */
    public function setUser( $user ) {
        $this->_user = $user;
    }

    /**
     * @param mixed $leftMenu
     */
    public function setLeftMenu( $leftMenu ) {
        $this->_leftMenu = $leftMenu;
    }

    /**
     * @param array $js
     */
    public function setJs( $js ) {
        $this->_js = $js;
    }

    /**
     * @return string $JsHTML
     */
    public function getJsHTML() {
        $JsHTML = '';
        foreach ( $this->_js as $scriptName ) {
            $JsHTML .= "<script src=\"$scriptName\"></script>";
        }
        return $JsHTML;
    }

    /**
     * @param array $css
     */
    public function setCss( $css ) {
        $this->_css = $css;
    }

    /**
     * @return string
     */
    public function getCSSHTML() {
        $CssHTML = '';
        foreach ( $this->_css as $cssName ) {
            $CssHTML .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"$cssName\">";
        }
        return $CssHTML;
    }
}