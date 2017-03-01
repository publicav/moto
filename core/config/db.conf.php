<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.01.2017
 * Time: 11:58
 */
 return [
     'host' => "localhost",
     'user' => "root",
     'pass' => "1234",
     'dbname' => "motors",
     'charset' => "utf8",
     'optimization' => [
         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
     ]
 ];

