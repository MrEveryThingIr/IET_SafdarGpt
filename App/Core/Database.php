<?php
namespace App\Core;
use PDO;
use PDOException;
class Database {
    private static $instance = null;
    private $connection;
    public function __construct(){
        $host    =  config("database.host");
        $user    =  config("database.username");
        $pass    =  config("database.password");
        $db_name =  config("database.db_name");
        $port    =  config("database.port");
        $charset =  config("database.charset");

        $dsn="mysql:host={$host};dbname={$db_name};port={$port};charset={$charset}";

        try{
            $this->connection = new PDO($dsn, $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("database hasn't connected!". $e->getMessage());
        }
    }

    public static function getInstance(){
        if(self::$instance==null){
            self::$instance=new Database();
    }
    return self::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }

    private function __clone(){}

    public function __wakeup(){}

    
}
