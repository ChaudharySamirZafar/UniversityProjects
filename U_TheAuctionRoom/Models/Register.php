<?php

require_once('userDataSet.php');

class Register
{
    /**
     * @param string email
     * @param string emailTwo
     * @return boolean
     * checks if both emails are matching
     * true if emails match
     * false if emails do not match
     */
    function checkEmail($email, $emailTwo)
    {
        $email = strtolower($email);
        $emailTwo = strtolower($emailTwo);
        if ($email == $emailTwo) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string password
     * @param string passwordTwo
     * @return boolean
     * checks if both passwords are matching
     * true if passwords match
     * false if passwords do not match
     */
    function checkPassword($password, $passwordTwo)
    {
        if ($password == $passwordTwo) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @return bool
     * checks if the email doesnt already exist
     * if the email exists returns true
     * else returns false
     */
    function checkEmailWithDB($email){
        $userDataSet = new userDataSet();
        if ($userDataSet->checkIfUserExists($email) !=  null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @param $name
     * @param $password
     * @param $email
     * registers the user and adds the data into the db
     */
    function registerUser($name,$password,$email){
        $userDataSet = new userDataSet();
        $userDataSet->registerUser($name,$password,$email);
    }
}

