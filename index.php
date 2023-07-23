<?php

class MyQueryBuilder{
    private $dbType;
    private $login;
    private $password;
    private $host;
    private $dbName;
    private $connection;
    private $query = "";

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
            $this->query = "SELECT {$colums}";
        }
        return $this;
    }

    public function insert($table, $colums){
        $this->query .= "INSERT INTO {$table}(";
        if(gettype($colums)=="array"){
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
            $this->query .= $colums;
        }
        $this->query .= ")";
        return $this;
    }

    public function delete(){
        $this->query .= "DELETE";
        return $this;
    }

    public function update($table){
        $this->query .= "UPDATE {$table}";
        return $this;
    }

    public function from($table){
        $this->query .= " FROM ".$table;
        return $this;
    }

    public function values($values){
        $this->query .= " VALUES (";
        if(gettype($values)=="array"){
            $size = count($values);
            for($i=0;$i<$size;$i++){
                if($i==($size-1)){
                    $this->query .= $values[$i];
                }else{
                    $this->query .= $values[$i].", ";
                }
            }
        }
        if(gettype($values)=="string"){
            $this->query .= $values;
        }
        $this->query .= ")";
        return $this;
    }

    public function set($colum, $value){
        if(strpos($this->query, "SET")){
            $this->query .= ", {$colum} = {$value}";
        }else{
            $this->query .= " SET {$colum} = {$value}";
        }
        return $this;
    }

    public function where($colum, $operator, $variable){
        if(strpos($this->query, "WHERE")){
            $this->query .= " AND {$colum} {$operator} {$variable}";
        }else{
            $this->query .= " WHERE {$colum} {$operator} {$variable}";
        }
        return $this;
    }

    public function limit($limit, $offset=0){
        $this->query .= " LIMIT {$limit}";
        if($offset!=0){
            $this->query .= ", {$offset}";
        }
        return $this;
    }

    public function orderBy($colums){
        $this->query .= " ORDER BY ";
        if(gettype($colums)=="array"){
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
            $this->query .= $colums;
        }
        return $this;
    }

    public function descendingSort(){
        $this->query .= " DESC";
        return $this;
    }

    public function ascendingSort(){
        $this->query .= " ASC";
        return $this;
    }

    public function execute(){
        try{
            return $this->connection->query($this->query.";");
        }catch(PDOException $e){
            return $e;
        }
    }
}

?>