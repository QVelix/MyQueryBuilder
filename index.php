<?php
class MyQueryBuilder{
    private $dbType;
    private $login;
    private $password;
    private $host;
    private $dbName;
    private $connection;

    public function __construct($config)
    {
        $this->dbType = $config['dbType'];
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->host = $config['host'];
        $this->dbName = $config['dbName'];
    }
}

?>