<?php

include_once('../Models/user.php');
include_once('../Models/AuctionItemDataSet.php');

//Create a auctionItemDataSet variable to interact with the database
$auctionData = new AuctionItemDataSet();
//Create a user variable to retrieve network key information
$user = new User();

//two variables that will store the offset and limit
$page_first_result = 0;
$results_per_page = 0;

$page_first_result = "";
$results_per_page = "";

//if both offset and limit have been set then execute the body
if (isset($_GET['offset']) && isset($_GET['limit'])) {

    global $page_first_result;
    global $results_per_page;

    //assign the two variables the corresponding values from the request
    $page_first_result = $_GET['offset'];
    $results_per_page = $_GET['limit'];

    //create a token variable and if the network key session is created then assign that to the token variable
    $token = "";
    if (isset($_SESSION['networkKey'])){
        $token = $_SESSION['networkKey'];
    }

    //if the token given in the request is not the same as the one set or it isn't set then execute the body
    //else call the method of loadLots()
    if ($token != $_GET['token'] || !isset($_GET['token'])) {
        echo "not working";
    }
    else{
        loadLots();
    }

}

/**
 * this function takes in consideration of the filters applied and returns the lots for the scroll in JSON format for the JS to manipulate
 */
function loadLots()
{

    global $page_first_result;
    global $results_per_page;
    global $auctionData;

    //if both max and min and the filter is set then execute a certain query depending upon which filter
    if (isset($_SESSION['min']) && isset($_SESSION['max']) && isset($_SESSION['filters'])) {
        if ($_SESSION['filters'] == 'lowToHigh') {
            echo json_encode($auctionData->fetchCategoryPriceLowToHighRange($_SESSION['searchedCategory'], $page_first_result, $results_per_page, $_SESSION['min'], $_SESSION['max']));
        } else if ($_SESSION['filters'] == 'highToLow') {
            echo json_encode($auctionData->fetchCategoryPriceHighToLowRange($_SESSION['searchedCategory'], $page_first_result, $results_per_page, $_SESSION['min'], $_SESSION['max']));
        }
    } //if the min and max are only set then get the category according to the range
    else if (isset($_SESSION['min']) && isset($_SESSION['max'])) {
        echo json_encode($auctionData->fetchSpecificCategoryRange2($_SESSION['searchedCategory'], $_SESSION['min'], $_SESSION['max'], $page_first_result, $results_per_page));
    } //if only the filters are set then retrieve results according to which filter has been selected
    else if (isset($_SESSION['filters']) == true) {
        if ($_SESSION['filters'] == 'lowToHigh') {
            echo json_encode($auctionData->fetchCategoryPriceLowToHigh($_SESSION['searchedCategory'], $page_first_result, $results_per_page));
        } else if ($_SESSION['filters'] == 'highToLow') {
            echo json_encode($auctionData->fetchCategoryPriceHighToLow($_SESSION['searchedCategory'], $page_first_result, $results_per_page));
        }
    } else {
        echo json_encode($auctionData->fetchCategory($_SESSION['searchedCategory'], $page_first_result, $results_per_page));
    }

}