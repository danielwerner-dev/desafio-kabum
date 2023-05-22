<?php

namespace Lib\Database;

/*
 * Classe para a conexão com o banco de dados
 */
class Connection {

    private static $PDO;
    private static $host = DATABASE["HOST"];
    private static $dbname = DATABASE["DBNAME"];
    private static $user = DATABASE["USER"];
    private static $password = DATABASE["PASSWORD"];

    /**
     * Estou garantindo que nenhuma instância da classe seja criada.
    */
    private function __construct() {}

    /**
     * Objeto de conexão
     */
    public static function getConnection() {
        if (!isset(self::$PDO)) {
           $opcoes = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', \PDO::ATTR_PERSISTENT => TRUE, \PDO::MYSQL_ATTR_FOUND_ROWS => true);  
           $driver = "mysql:host=" . self::$host . "; dbname=" . self::$dbname . "; charset=utf8;";
           self::$PDO = new \PDO ($driver, self::$user, self::$password, $opcoes);
        }
        
        return self::$PDO;
    }
}
