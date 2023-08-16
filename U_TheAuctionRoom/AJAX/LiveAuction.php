<?php
include_once('../Models/AuctionItemDataSet.php');
include_once('../Models/user.php');

//Create a auctionItemDataSet variable to interact with the database
$dataset = new AuctionItemDataSet();
//Create a user variable to retrieve network key information
$user = new User();

//Decode the array that was given in json format
//the array will consists of a series of lot ID's
$arrayOfLots = json_decode($_GET['lotsArray']);

//if the array size is larger then 0 then execute the body
if (sizeof($arrayOfLots) > 0){

    //create a token variable and if the network key session is created then assign that to the token variable
    $token = "";
    if (isset($_SESSION['networkKey'])){
        $token = $_SESSION['networkKey'];
    }

    //if the token given in the request is not the same as the one set or it isn't set then execute the body
    //else call the method of checkOutBids()
    if ($token != $_GET['token'] || !isset($_GET['token'])) {
        echo "not working";
    }
    else
        checkOutBids();
}

/**
 * a method that returns a series of Bids object will include the maximum bid on a item
 */
function checkOutBids(){
    global $dataset;
    global $arrayOfLots;

    echo json_encode($dataset->fetchBid($arrayOfLots));
}




