<?php

class Database
{

    protected static $_dbInstance = null; //static instance
    protected $dbHandle;

    /**
     * @return Database|null
     * returns a dbInstance
     */
    public static function getInstance()
    {
        $username = 'root';
        $password = 'samir786';
        $host = 'localhost';
        $dbName = 'aee363';

        //checks if instance exists if not creates a new connection
        if (self::$_dbInstance === null)
        {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }

    private function __construct($username, $password, $host, $dbName)
    {
        try {
            $this->dbHandle = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
            //creates the database handle with connection info
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return PDO
     * returns the current connection so it can be used elsewhere
     */
    public function getDbConnection()
    {
        return $this->dbHandle;
    }

    /**
     * destorys the PDO handle when no longer needed
     */
    public function __destruct()
    {
        $this->dbHandle = null;
    }
}