<?php

use function PHPSTORM_META\type;

class MyQueryBuilder{
    private $dbType;
    private $login;
    private $password;
    private $host;
    private $dbName;
    private $connection;
    private $query;

    public function __construct($config)
    {
        $this->dbType = $config['dbType'];
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->host = $config['host'];
        $this->dbName = $config['dbName'];
        $this->createConection();
    }

    private function createConection(){
        $dsn = $this->dbType.":host=".$this->host.";dbname=".$this->dbName.";charset=utf8";
        $this->connection = new PDO($dsn, $this->login, $this->password, array(PDO::ATTR_PERSISTENT=>true));
    }

    public function select($colums){
        if(gettype($colums)=="array"){
            $this->query = "SELECT ";
            $size = count($colums);
            for($i=0;$i<$size;$i++){
                if($i==($size-1)){
                    $this->query .= $colums[$i];
                }else{
                    $this->query .= $colums[$i].", ";
                }
            }
        }
        if(gettype($colums)=="string"){
            $this->query = "SELECT ".$colums;
        }
    }

    public function from($table){
        $this->query .= "FROM ".$table;
    }
}

?>