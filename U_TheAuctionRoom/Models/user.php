<?php

require_once('userDataSet.php');

class User
{
    protected $email, $password, $isLoggedIn;
    protected $userData;
    protected $isAdmin;
    protected $userID;
    protected $userName;
    protected $networkKey;


    function __construct()
    {
        //Start the session
        session_start();
        $this->email = null;
        $this->password = null;
        $this->isLoggedIn = false;
        $this->userID = null;
        $this->isAdmin = null;
        $this->userName = null;

        //if session has already been set then set all of the fields to the session values
        if (isset($_SESSION['logIn'])) {
            $this->email = $_SESSION['logIn'];
            $this->password = $_SESSION['password'];
            $this->isLoggedIn = true;
            $this->userID = $_SESSION['userID'];
            $this->isAdmin = $_SESSION['isAdmin'];
            $this->userName = $_SESSION['userName'];
        }

    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * validates details of the user log in process
     */
    function validateDetails($email, $password)
    {
        //changes the email given to lower
        $lowerEmail = strtolower($email);
        $this->userData = new userDataSet();
        //currentUser will equal to a UserData variable if the details are correct
        $currentUser = $this->userData->fetchUser($lowerEmail,$password);

        //if the currentUser is not null then set all sessions and variables
        if ($currentUser != null) {
            $_SESSION['logIn'] = $email;
            $_SESSION['password'] = $password;
            $this->email = $email;
            $this->password = $password;

            //accessing the returned userData variable to access variables
            $this->userID = $currentUser->getUserID();
            $this->isAdmin = $currentUser->getIsAdmin();
            $this->userName = $currentUser->getName();

            //making a session variable to help maintain state
            $_SESSION['isAdmin'] =  $this->isAdmin;
            $_SESSION['userID'] = $this->userID;
            $_SESSION['userName'] = $this->userName;
            $this->isLoggedIn = true;
            return true;
        } else {
            $this->isLoggedIn = false;
            return false;
        }
    }

    /**
     * unsets all sessions
     * makes all variables null
     */
    function logOut()
    {
        unset($_SESSION['logIn']);
        unset($_SESSION['password']);
        unset($_SESSION['isAdmin']);
        unset($_SESSION['userID']);
        unset($_SESSION['userName']);
        $this->email = null;
        $this->password = null;
        $this->isLoggedIn = false;
        $this->userID = null;
        $this->isAdmin = null;
        $this->userName = null;
        session_destroy();
    }

    //provides new network key
    public function newNetworkKey(){
        $this->networkKey = substr(str_shuffle(MD5(microtime())), 0,20);
        $_SESSION['networkKey'] = $this->networkKey;
    }


    /**
     * @return bool
     * accessor method for logged in status
     */
    public function loggedIn()
    {
        return $this->isLoggedIn;
    }

    /**
     * @return string
     * accessor method for user email
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return int
     * accessor method for user ID
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return string
     * accessor method for users name
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return int
     * accessor method for admin status
     */
    public function getAdminStatus()
    {
        return $this->isAdmin;
    }
}

