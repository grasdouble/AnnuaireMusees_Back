<?php

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 27/05/2015
 * Time: 00:20
 */
class Database extends MySQLi
{
    private static $instance = null;

    private function __construct($host, $user, $password, $database)
    {
        parent::__construct($host, $user, $password, $database);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self('127.0.0.1', 'AnnuaireMusees', 'pwd2015', 'AnnuaireMusees');
        }
        return self::$instance;
    }
}

//
