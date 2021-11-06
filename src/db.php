<?php

# Выполняем подключение к БД
class DB {
    
    # Локальное подключение
    /*
    const USER = "tublat";
    const PASS = "12345";
    const HOST = "localhost";
    const DB = "wiki";   
     */
     
    
    # Удаленное подключение
    
    const USER = "auGTLg2MG9";
    const PASS = "JbF5EqIV4f";
    const HOST = "remotemysql.com";
    const DB = "auGTLg2MG9";
    
    
    # Подключение Cuba
    /*
    const USER = "dev_roman";
    const PASS = "83rPpywO8y";
    const HOST = "localhost";
    const DB = "wiki"; 
     
     */
    
    public static function connToDB(){
            
        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $db = self::DB;


            $conn = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
            return $conn;
    }
}

