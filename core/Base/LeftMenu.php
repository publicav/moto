<?php
/**
 * Created by PhpStorm.
 * User: mama
 * Date: 16.02.2017
 * Time: 17:28
 */

namespace Base;

use Pdo\GetMenuLeft;
use Pdo\Privelege;

class LeftMenu {
    protected $_privelege;
    protected $_getMenuLeft;
    protected $_sq;
    protected $_sqlData = null;

    public function __construct( Privelege $privelege, GetMenuLeft $getMenuLeft ) {
        $this->_privelege = $privelege;
        $this->_getMenuLeft = $getMenuLeft;
        return $this;
    }

    public function getDataForm() {
        $priv = $this->_privelege->getPriv();
        $menuLeftData = $this->_getMenuLeft->getMenuLeftData();
        $countPriv = count( $priv );
        $countLeftMenu = count( $menuLeftData );

        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            for ( $j = 0; $j < $countPriv; $j++ ) {
                if ( ( $menuLeftData[ $i ]['id_menu'] == $priv[ $j ]['id_menu'] ) AND ( $priv[ $j ]['visibly'] == 1 ) ) {
                    $menuLeftData[ $i ]['checked'] = 'checked="checked"';
                    break;
                }
            }
            $menuLeftFormPriv[] = $menuLeftData[ $i ];
        }
        return $menuLeftFormPriv;

    }

    public function setSqlData( array $dataCheck ) {
        $id_user = $this->_privelege->getId();
        $menuLeftData = $this->_getMenuLeft->getMenuLeftData();
        $countLeftMenu = count( $menuLeftData );

        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            $sqlData[] = [ 'id_users' => $id_user,
                           'id_menu'  => $menuLeftData[ $i ]['id_menu'],
                           'visibly'  => $dataCheck[ $i ],
            ];
        }
        $this->_sqlData = $sqlData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSqlData() {
        return $this->_sqlData;
    }

    public function getSqlFields() {
        $countSqlData = count( $this->getSqlData() );
        if ( $countSqlData == 0 ) return null;
        return 'id,' . implode( ',', array_keys( $this->getSqlData()[0] ) );
    }


    public function getSqlValues() {
        $priv = $this->_privelege->getPriv();
        $sqlData = $this->getSqlData();
        $countPriv = count( $priv );
        $countSqlData = count( $sqlData );
        $privelege_var = '';
        for ( $i = 0; $i < $countPriv; $i++ ) {
            $row = '(' . $priv[ $i ]['id'] . ',' . implode( ',', $sqlData[ $i ] ) . '),';
            $privelege_var .= $row;
        }
        for ( $j = $i; $j < $countSqlData; $j++ ) {
            $row = '(' . "NULL," . implode( ',', $sqlData[ $j ] ) . '),';
            $privelege_var .= $row;
        }

        $privelege_var = trim( $privelege_var, ',' );
        return $privelege_var;
    }

    public function savePrivelegeForm() {
        $pdo = \DB::getLink()->getDb();
        $fields = $this->getSqlFields();
        $values = $this->getSqlValues();
        $sq = "REPLACE INTO tables_priv_new ( $fields ) VALUES $values;";

        $res = $pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
        $this->_sq = $sq;

    }

    public function getSql() {
        return $this->_sq;
    }
}