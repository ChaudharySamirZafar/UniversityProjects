<?php
require_once('Models/user.php');
require_once('Models/AuctionItemDataSet.php');
//this variable will help with maintaining state
$user = new User();

$view = new stdClass();

// a view variable to help view display an error message if the answer of the captcha wrong
$view->captchaError = false;
// a view variable to help view display an success message if item has successfully been added
$view->success = false;
//array to store captcha numbers
$numbers = [];


/**
 * @return array
 * function that returns two random numbers from range 1 to 50 inclusive
 * creates a session for the correct answer to check if the users answer is correct
 */
function generateRandom()
{
    global $numbers;
    $numbers[0] = rand(1,50);
    $numbers[1] = rand(1,50);
    $_SESSION['answer'] = $numbers[0] +  $numbers[1];
    return $numbers;
}

/**
 * @return array
 * function to retrieve all current planned auctions dates
 */
function getDates(){
    $a = new AuctionItemDataSet();
    return $a ->retrieveAllAuctionDates();
}


//if the submit button is pressed then check if the answer is correct
if(isset($_POST['submitBtn'])) {
    //if the answer to the captcha is correct then list the item and add information to db and unset the answer else show an error
    if($_POST["captcha-answer"] == $_SESSION['answer'] )
    {
        $a = new AuctionItemDataSet();
        $insertAllImages = uploadPicture();
        $a->listItem(htmlentities($_POST['product-list-date']),htmlentities($user->getUserID()),htmlentities($_POST['product-Name']),
            htmlentities($_POST['product-Title']),htmlentities($_POST['product-Category']),htmlentities($_POST['product-description'])
            ,htmlentities($_POST['product-startingBid']),$insertAllImages);
        $view->success = true;
        unset($_SESSION['answer']);
    }
    else
    {
        $view->captchaError = true;
    }
}

/**
 * @return array
 * uploads images to directory
 */
function uploadPicture(){

    //counts how many pictures have been submitted
    $countFiles = count($_FILES['fileToUpload']['name']);
    //sets the target directory for the image
    $target_dir = "Images/";
    $arrOfImages = [];

    for($i=0;$i<$countFiles;$i++) {
        //checks for the fileName
        $filename = $_FILES['fileToUpload']['name'][$i];
        //Specifying what path the image should be placed in mine will Images/pictureName/.jpg
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        //uploading the file
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
        $arrOfImages[$i] = $target_file;

    }
    return $arrOfImages;
}

/**
 * @return int
 * check if the user has live listings right now and if so will display a link to preview them
 */
function fetchThisUsersListings(){
    global $user;
    $auctionData = new AuctionItemDataSet();
    return count($auctionData->retrieveUsersCurrentListing($user->getUserID()));
}

/**
 * @return int
 * check if the user has future listings and if so will display a link to preview them
 */
function fetchThisUsersFutureListings(){
    global $user;
    $auctionData = new AuctionItemDataSet();
    return count($auctionData->retrieveUsersFutureListing($user->getUserID()));
}

include_once('Views/sellItems.phtml');


