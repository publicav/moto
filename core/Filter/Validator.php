<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 30.01.2017
 * Time: 7:31
 */

namespace Filter;


class Validator {
    protected $_errors = [];
    protected $_rules = [];
    protected $_fields = [];
    protected $_data = [];

    public function __construct( $data, $rules ) {
        $this->_data = $data;
        $this->_rules = $rules;

        $this->_fields = array_keys( $rules );
    }

    /**
     * @return array
     */
    public function getFields() {
        return $this->_fields;
    }

    protected function required( $field ) {
        if ( empty( $this->_data[ $field ] ) ) {
            if ( isset( $this->_data[ $field ] ) ) return;
            $this->addError( $field, "поле  $field пустое!" );
        }

    }

    protected function isPositive( $field ) {
        $positive = (int)$this->_data[ $field ];
        if ( $positive <= 0 ) {
            $this->addError( $field, 'Число не является положительным' );
        }

    }

    protected function aboveZerroInt( $field ) {
        if ( empty( $this->_data[ $field ] ) ) return;
        if ( !preg_match( '/^\+?\d+$/', $this->_data[ $field ] ) ) {
            $this->addError( $field, 'Число не является положительным и не равно нулю' );
        }

    }

    protected function DateDMY( $field ) {
        if ( empty( $this->_data[ $field ] ) ) return;
        $date = \DateTime::createFromFormat( 'd-m-Y', $this->_data[ $field ] );
        if ( !$date ) {
            $this->addError( $field, 'Date format error!' );
        }
    }

    protected function isDate( $field ) {
        if ( empty( $this->_data[ $field ] ) ) return;
        $date = \DateTime::createFromFormat( 'Y-m-d', $this->_data[ $field ] );
        if ( !$date ) {
            $this->addError( $field, 'Date format error!' );
        }
    }

    protected function TimeSet( $field ) {
        $date = \DateTime::createFromFormat( 'H:i', $this->_data[ $field ] );
        if ( !$date ) {
            $this->addError( $field, 'Time format error!' );
        }

    }

    protected function notEmpty( $field ) {
        if ( empty( $this->_data[ $field ] ) ) {
            $this->addError( $field, 'Пустое значение' );
        }
    }

    protected function rangeLogin( $field ) {
        $login = $this->_data[ $field ];
        if ( ( strlen( $login ) <= 3 ) and ( strlen( $login ) > 11 ) ) {
            $this->addError( $field, 'Login out of range!' );
        }
    }

    protected function uniqueLogin( $field ) {
        $pdo = \DB::getLink()->getDb();
        $user = $this->_data[ $field ];
        $sq = "SELECT id FROM users WHERE users = :user";
        $param = [ 'user' => $user ];
        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
        $gId = $res->fetchAll();
        if ( !empty( $gId ) ) {
            $this->addError( $field, 'Такой пользователь существует' );
        }

    }

    protected function confirmPassword( $field ) {
        $password = $this->_data[ $field ];
        $keyArr = explode( '_', $field );
        $key = "{$keyArr[0]}_repeat_{$keyArr[1]}";
        if ( $password != $this->_data[ $key ] ) {
            $this->addError( $field, 'Пароли не совпадают' );
        }

    }

    protected function minPassword( $field ) {
        $password = $this->_data[ $field ];
        if ( ( strlen( $password ) < 3 ) ) {
            $this->addError( $field, 'Длина пароля меньше 3 символов' );
        }

    }

    public function addError( $field, $error ) {
        $this->_errors[ $field ] = $error;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->_errors;
    }

    public function getError( $key ) {
        if ( array_key_exists( $key, $this->_errors ) ) return $this->_errors[ $key ];
    }

    public function validateThis() {
        foreach ( $this->_rules as $field => $rules ) {
            foreach ( $rules as $rule ) {
                if ( method_exists( $this, $rule ) ) {
                    if ( is_null( $this->getError( $field ) ) ) {
                        $this->$rule( $field );
                    }
                } else {
                    throw new \Exception( 'Error metod not found!' );
                }
            }
        }
        if ( !empty( $this->_errors ) ) {
            return false;
        }
        return true;

    }

}