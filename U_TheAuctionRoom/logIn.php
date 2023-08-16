<?php
include_once("Models/user.php");


$view = new stdClass();

//sets the error variable to false in the view class
$view->error = false;

//Creates a user class to keep track of the log In status
$user = new User();


//an if statement to acknowledge the details
//an user has given, if the details are correct they will be logged in

if (isset($_POST['logInButton'])) {
    //if the user details are correct then set cookies for remembering email
    //else change view error to true so view can display error
    if ($user->validateDetails(htmlentities($_POST['email']),htmlentities($_POST['password']) )) {
        setcookie('email',$_POST['email'], time()+30*24*60*60);
        //if the remember password is ticked then create a cookie for the password
        if (isset($_POST['rememberPassword']))
        {
            if($_POST['rememberPassword'] == true)
            {
                setcookie('password',$_POST['password'],time()+30*24*60*60);
            }
        }
        else{
            setcookie('password','');
        }
        $view->error = false;
    } else {
        $view->error = true;
    }
}



//if the user presses the logOut button
//call the logOut function from the user.php
//
if (isset($_POST['logOutBtn'])) {
    $user->logOut();
    header("Refresh:0");
}

//if the user is logged in then show log out page else show the log in page
if ($user->loggedIn() == true) {
    require_once('Views/logOut.phtml');
}
if($user->loggedIn() == false) {
    require_once('Views/logIn.phtml');
}




