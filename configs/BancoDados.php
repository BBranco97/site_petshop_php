<?php

class Conexao {

    private static $inst;

    private function __construct(){
        $hostname = "localhost";
        $database = "petshop";
        $username = "root";
        $password = "";

        $dsn = "mysql:host=$hostname;dbname=$database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            self::$inst = new PDO($dsn, $username, $password, $options);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getConexao(){
        if (!isset(self::$inst)) {
            new Conexao();
        }
        return self::$inst;
    }
}