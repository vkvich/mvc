<?php
namespace app\config;
use  app\classes\Connection;


class Main extends \mysqli
{
    public $dbConnection;
    function __construct()
    {
        parent::__construct();
        $config = require 'db.php';
        $connection= new Connection();
        $this->dbConnection = $connection->connect($config['server'],$config['userName'],$config['password'],$config['databaseName'],$config['charset']);
    }

}
