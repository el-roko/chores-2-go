<?php
require_once "config.php";


class Db
{
    private $dbhost = DB_HOST;
    private $dbuser = DB_USER;
    private $dbpass = DB_PASS;
    private $dbname = DB_NAME;


    protected function connect(){
         $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $option =[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
          try{
                $pdo = new PDO($dsn,$this->dbuser,$this->dbpass,$option);
                return $pdo;
        }catch(PDOException $e){
                // return $e->getMessage();
                return false;
        }
    }



  
  }
   
   


?>