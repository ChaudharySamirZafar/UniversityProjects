<?php

require_once('Models/Register.php');
require_once('Models/user.php');

//Register variable created for registering process
$register = new Register();

$view = new stdClass();
// a variable to track email errors
$view->emailError = false;
// a variable to track password errors
$view->passwordError = false;
// a variable to check if they successfully register, if so it will allow view to show a success message
$view->registered = false;
// if the emails are the same then the view will display a error according to this variable
$view->sameEmail = false;
$user = new user();



//runs a if check to see whether the register button has been pressed
//Check if the emails are identical
//Checks if the passwords are identical
//If Both are false then registers the users successfully

if (isset($_POST['registerBtn']) == true) {

    //checks if the two emails match if not
    //makes the emailError true for the view to display
    if ($register->checkEmail(htmlentities($_POST['email1']), htmlentities($_POST['email2'])) == false) {
        $view->emailError = true;
    }

    //checks if the two password match if not
    //makes the passwordError true for the view to display
    if ($register->checkPassword(htmlentities($_POST['password1']), htmlentities($_POST['password2'])) == false) {
        $view->passwordError = true;
    }

    //Checks if the email doesnt already exist, if not makes the sameEmail error true
    if ($register->checkEmailWithDB(htmlentities($_POST['email1'])) == false){
        $view->sameEmail = true;
    }

    //if both emailError and passwordError are false
    //then makes the registered success alert pop up through the view.
    if ($view->emailError == false && $view->passwordError == false && $view->sameEmail==false) {
        $view->registered = true;
        $lowerEmail = strtolower($_POST['email1']);
        $password = $_POST['password1'];
        $encryptedPassword = password_hash($password,PASSWORD_DEFAULT);
        $register->registerUser(htmlentities($_POST['name']),$encryptedPassword ,$lowerEmail);
    }
}

include_once('Views/register.phtml');

