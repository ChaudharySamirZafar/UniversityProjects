<?php
include_once('Models/user.php');
include_once('Models/AuctionItemDataSet.php');

//A user variable to maintain state
$user = new User();

//auction data allows to interact with DB by executing SQL queries and returning answers
$auctionData = new AuctionItemDataSet();

$view = new stdClass();
$view->id = null;

/**
 * @return array
 * a function that retrieves all of the users item they have listed
 * the item has to be part of the live auction
 */
function fetchUsersCurrentListings()
{
    global $user;
    global $auctionData;
    return $auctionData->retrieveUsersCurrentListing($user->getUserID());
}

/**
 * @return array
 * a function that retrieves all of the users item they have listed in the future
 * the item has to be part of future auctions
 */
function fetchUsersFutureListings(){
    global $user;
    global $auctionData;
    return $auctionData->retrieveUsersFutureListing($user->getUserID());
}




include_once('Views/listedItems.phtml');
