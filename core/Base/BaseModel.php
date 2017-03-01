<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 22:03
 */

namespace Base;

use Filter\Validator;
use Navigation\Route;

abstract class BaseModel {
    protected $_pdo;
    protected $_data;
    protected $_errors = [];
    protected $_config;
    protected $_route;
    protected $_validator = null;

    abstract function getRules();

    function __construct() {
        $this->_pdo = \db::getLink()->getDb();
        $this->_config = Registry::init();
        $this->_route = Route::init();
    }

    public function validate() {
        $validator = new Validator( $this->_data, $this->getRules() );
        if ( !$validator->validateThis() ) {
            $this->_errors = $validator->getErrors();
            return false;
        }
        return true;
    }

    /**
     * @param array $date
     * @return bool
     */
    public function load( $date ) {
        foreach ( $date as $property => $value ) {
            if ( property_exists( static::class, $property ) ) {
                $this->$property = $value;
                $this->_data[ $property ] = $value;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->_errors;
    }

    public function getFirstError() {
        foreach ( $this->getErrors() as $field => $error ) {
            $firstError = [ 'error' => [ $field, $error ] ];
            return $firstError;
        }

    }

    public function getResult() {
        return $this->result;
    }
}