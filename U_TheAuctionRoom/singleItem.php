<?php
include_once('Models/user.php');
include_once('Models/AuctionItemDataSet.php');


//created a user variable in order to maintain state
$user = new User();
$itemData = new AuctionItemDataSet();
// a variable to keep track of the maximum bid on the specific item
$maxBid = 0;

//if the view btn is pressed then create a session that is equals to the specific item id
//so when the user presses bid the post value will unset
if (isset($_POST['viewBtn'])) {
    $_SESSION['auctionID'] = $_POST['auctionID'];
}

//Create view variables that will store all the information of the particular item
$view = new stdClass();
$view->deleted = false;
$view->loggedInErr = false;
$view->invalidBid = false;
$view->validBid = false;
$view->getUserId = $user->getUserID();

//retrieves all of the item data
$data = $itemData->fetchIndividualItem($_SESSION['auctionID']);
//retrieves the maximum bid placed on the item
$maxBid = $itemData->getMaxBid($_SESSION['auctionID']);

//assigns all of the view variable the relevant information
    $imagePath = $data->getImagePath();
    $view->imagePath = $imagePath;
    $view->productTitle = $data->getProductTitle();
    $view->startingBid = $data->getMinimumBid();
    $view->endDate = $data->getEndDate();
    $view->description = $data->getProductDescription();
    $view->startDate = $data->getStartDate();
    $view->userId =  $data->getUserID();

//if the max bid is still 0 then set the currentBid to 0
//and set the startingBid the same as the minimum bid + 1
//else make current bid = max bid
if ($maxBid == 0) {
    $view->currentBid = 0;
    $view->leastAmount = $view->startingBid + 1;
} else {
    $view->currentBid = $maxBid;
    $view->leastAmount = $maxBid + 1;
}


/**
 * @return array
 * returns an array of Strings, which are the image paths
 */
function fetchAllImages(){
    global $itemData;
    return $images = $itemData->fetchAllImages($_SESSION['auctionID']);
}

// if the bid button is pressed and user is logged in then if the bid amount if larger then the max bid then place the bid
//else show a error message
if (isset($_POST['bidBtn'])) {
    global $itemData;
    //back end validation
    //get the maxBid of the item when the bid button is pressed
    $maxBid = $itemData->getMaxBid($_SESSION['auctionID']);

    if($user->loggedIn())
    {
        //if the bidAmount is larger then the maxBid then show a success message else show a unsuccessful message
        if($_POST['bidAmount'] > $maxBid)
        {
            $view->validBid = true;
            $itemData->placeBid($_SESSION['auctionID'],$user->getUserID(),htmlentities($_POST['bidAmount']));
            header("Refresh:2");
        }
        else if($_POST['bidAmount'] < $maxBid)
        {
            $view->invalidBid = true;
        }
        else if($_POST['bidAmount'] == 0)
        {
            $view->invalidBid = true;
        }
    }
    else
    {
        $view->loggedInErr = true;
    }
}

//if the delete button is pressed then delete the item
if(isset($_POST['delete']))
{
    $view -> deleted = true;
    $itemData->deleteAuction($_SESSION['auctionID']);
}

require_once('Views/sinlgeItem.phtml');

