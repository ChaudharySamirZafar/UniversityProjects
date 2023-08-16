
<?php
include_once('Models/user.php');
//A user variable is declared to keep track of the state
$user = new User();

//Set the session for the search category null, so when the user search's
//from the home page it is done for all types of categories or the specified  category
$_SESSION['searchedCategory'] = null;
include_once('Views/index.phtml');