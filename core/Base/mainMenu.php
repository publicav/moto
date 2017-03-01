<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2017
 * Time: 19:30
 */

namespace Base;


class mainMenu {
    protected $_menu;
    protected $_menuArray;
    protected static $_link = null;

    public function __construct( $menuFile ) {
        $this->openFile( $menuFile );
        $this->_menuArray = $this->stdToArray();
    }

    /**
     * @param $file
     * @throws \Exception
     */
    protected function openFile( $file ) {
        if ( !file_exists( $file ) ) {
            throw new \Exception( 'File not found! - ' . $file, '404' );
        }
        $json = file_get_contents( $file );
        $this->_menu = json_decode( $json );

    }

    protected function stdToArray() {
        $rc = (array)$this->_menu;
        foreach ( $rc as $key => &$field ) {
            if ( is_object( $field ) ) $field = $this->stdToArray( $field );
        }
        return $rc;
    }


    public static function getMenu( $menuFile ) {
        if ( is_null( self::$_link ) ) self::$_link = new self( $menuFile );
        return self::$_link;
    }

    public function render() {
        $mainMenu = $this->_menuArray['menu'];
        $content = '';
        $countMainMenu = count( $mainMenu );
        for ( $i = 0; $i < $countMainMenu; $i++ ) {
            $content .= "<li>
                            <a id=\"{$mainMenu[$i]->id_a}\" href=\"{$mainMenu[$i]->url}\">{$mainMenu[$i]->name}</a>
					  </li>
			";
        }
        echo $content;

    }


}