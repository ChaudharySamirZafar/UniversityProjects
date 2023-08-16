<?php

require_once('userData.php');
require_once('Database.php');

class userDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $email
     * @param $password
     * @return userData
     * fetches the user according to the parameters
     */
    public function fetchUser($email, $password)
    {

        $sqlQuery = "SELECT * FROM aee363.User WHERE UserEmail = ? ";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($email));
        $dataset = null;

        while ($row = $statement->fetch()) {
            if(password_verify($password,$row[2]))
            {
                $dataset = new userData($row);
            }
        }

        return $dataset;
    }

    /**
     * @param $email
     * @return array
     * checks if an email already exists
     */
    public function checkIfUserExists($email)
    {
        $sqlQuery = "SELECT UserEmail FROM aee363.User WHERE UserEmail = ?";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($email));
        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = $row;
        }

        return $dataset;
    }

    /**
     * @param $name
     * @param $password
     * @param $email
     * registers a user into the database
     */
    public function registerUser($name,$password,$email)
    {
        $sqlQuery = "insert into User (Name, UserPassword, UserEmail) values  (?,?,?)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($name,$password,$email));
    }
}
