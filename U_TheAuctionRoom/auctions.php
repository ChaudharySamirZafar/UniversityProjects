<?php
include_once('Models/user.php');
include_once('Models/AuctionItemDataSet.php');

//Creating a variable that is type of User in order to maintain state
$user = new User();
//AuctionData variable is a variables that runs SQL queries and returns results
$AuctionData = new AuctionItemDataSet();

//Creating a view class to track error messages
$view = new stdClass();

//a delete error variable to show users if they have given a valid ID for deletion
//Success Message will show if the ID is valid
$view->DeleteError = false;
$view->successMessage = false;

//this variable is used to store the latestDate in the auction table
//this will be used for adding auctions, as the new auctions need to be later then current auctions
$latestDate = $AuctionData->getLatestDate();


/**
 * @return array
 * this method retrieves all the information about every auction
 * it returns an array for the view to use and display in a table
 */
function getAllCurrentAuctions()
{
    global $AuctionData;
    return $AuctionData->retrieveAllAuctionData();
}

//If the delete button is pressed execute the body of this IF statement
if(isset($_POST['delete']))
{
    //AuctionDates retrieves all the auction data for the current auctions in the table
    $auctionDates = $AuctionData->retrieveAllAuctionData();
    //found is variable to keep track if they have entered a valid Auction ID
    $found = false;
    foreach ($auctionDates as $date)
    {
        //if a valid Auction ID has been given then make found = true and break out of the loop
        if ($date->getID() == $_POST['auctionID'])
        {
            $found = true;
            break;
        }
    }

    //if found is false then show an error message
    //else show a success message
    if($found == false)
    {
        $view->DeleteError = true;
    }
    else
    {
        $AuctionData->removeAuction(htmlentities($_POST['auctionID']));
        $view->successMessage = true;
    }
}


/**
 * @return array
 * the function retrieves the latestDate in the Auction Tables
 * and produces dates for 7 days after
 */
function productAuctionDates()
{
    global $latestDate;
    $allDates = [];
    $count = 0;
    //for loop to create 7 dates, each date is increment from one
    //the first initial date is one day ahead of the latest date in the table
    for($i = 1; $i<=7; $i++)
    {
        $allDates[$count] =  $next_date = date('Y-m-d', strtotime( $latestDate .' +'.$i.' day'));
        $count++;
    }

    return $allDates;
}

//if the create auction button is pressed then insert the auction into the table and refresh the page
if(isset($_POST['auction-add']) == true)
{
    $AuctionData->insertAuction(htmlentities($_POST['dates']));
    header('Location:auctions.php');
}



require_once('Views/auctions.phtml');