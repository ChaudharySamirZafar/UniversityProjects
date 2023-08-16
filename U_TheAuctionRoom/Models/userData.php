<?php


class userData
{

    private $_id, $_name, $_email, $_password, $_isAdmin;


    public function __construct($dbRow)
    {
        $this->_id = $dbRow['UserID'];
        $this->_name = $dbRow['Name'];
        $this->_email = $dbRow['UserEmail'];
        $this->_password = $dbRow['UserPassword'];
        $this->_isAdmin = $dbRow['isAdmin'];
    }

    /**
     * @return int
     * accessor method for user id
     */
    public function getUserID()
    {
        return $this->_id;
    }

    /**
     * @return string
     * accessor method for user name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     * accessor method for user email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return int
     * accessor method for user admin status
     */
    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }

}