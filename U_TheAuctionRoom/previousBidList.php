<?php
require_once('Models/user.php');
require_once('Models/AuctionItemDataSet.php');

//A user variable declared to maintain state throughout the website
$user = new User();
//BidData will call SQL queries in the AuctionItemDataSet class and returns results
$bidData = new AuctionItemDataSet();

$view = new stdClass();
//this variable will keep track of the users largest bid on the item
$userBidInfo = null;
//this variable will keep track of the auction item's largest bid
$maxBidInfo = null;

function generateAllPreviousBids(){
    global $user;
    global $bidData;
    global  $userBidInfo;
    global $maxBidInfo;

    //first collect all of the current live bids the user has
    $bidsOfUser = $bidData->getUsersPreviousBids($user->getUserID());
    $userBidInfo = $bidsOfUser;

    //now collect all of their max bids on the item, to see if they are the highest bidder
    //MaxBids will store the largest bid each item has
    $maxBids = [];
    //ArrayOfLots will store AuctionData variables that contain data of each auction item
    $arrayOfLots = [];


    for($i = 0; $i<count($bidsOfUser); $i++)
    {
        //Gets the max bid for the item and places in the array
        $maxBids[$i] = $bidData->getUsersMaxBids($bidsOfUser[$i],$user->getUserID());
        //Gets the AuctionData Variable and stores in
        $arrayOfLots[$i] = $bidData->getLot($bidsOfUser[$i]);
    }
    //Gives the values of maxBids to maxBidInfo
    $maxBidInfo = $maxBids;
    //Gives the values of bidsOfUser to userBidInfo
    $userBidInfo = $bidsOfUser;

    return $arrayOfLots;

}

/**
 * @return array
 * returns a array of the bid amount a user has placed on each item
 */
function getUserBidInfo()
{
    global $userBidInfo;
    return  $userBidInfo;
}

/**
 * @return array
 * returns a array of the largest bid amount any user has placed on each item that the current user has placed a bid on
 */
function getMaxBidInfo()
{
    global $maxBidInfo;
    return $maxBidInfo;
}

require_once('Views/previousBids.phtml');
