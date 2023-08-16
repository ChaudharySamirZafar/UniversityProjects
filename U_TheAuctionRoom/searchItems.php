<?php
include_once('Models/AuctionItemDataSet.php');
include_once('Models/user.php');

//variable used to maintain state
$user = new User();
$user->newNetworkKey();

//variable used to call SQL queries and return results
$auctionData = new AuctionItemDataSet();

//page link numbers will keep track of the amount of pages needed according to the search
$pageLinkNumbers = 0;
$view = new stdClass();
$selectedPage = 1;

//If the search watches button on home button is pressed the remove all filters and
//search Watches & Jewellery
if(isset($_POST['search-watches']))
{
    unset($_SESSION['filters']);
    unset($_SESSION['min']);
    unset($_SESSION['max']);
    $_SESSION['searchedCategory'] = 'Watches & Jewellery';
}

//If the search cars button on home button is pressed the remove all filters and
//search cars
if(isset($_POST['search-cars']))
{
    unset($_SESSION['filters']);
    unset($_SESSION['min']);
    unset($_SESSION['max']);
    $_SESSION['searchedCategory'] = 'cars';

}

//If the search books button on home button is pressed the remove all filters and
//search books
if(isset($_POST['search-books']))
{
    unset($_SESSION['filters']);
    unset($_SESSION['min']);
    unset($_SESSION['max']);
    $_SESSION['searchedCategory'] = 'books';

}


//if the search button is pressed then unset all the filters and if the
if (isset($_POST['searchBtn'])) {
    unset($_SESSION['filters']);
    unset($_SESSION['min']);
    unset($_SESSION['max']);
    //Sets the session to the post value, as you go through pages the post value is lost
    $_SESSION['searchedCategory'] = $_POST['categorySearch'];
}

//if the apply button is pressed alone then remove all filters
if(isset($_POST['submit']) && !isset($_POST['filters']) && !$_POST['price-min'] > 0)
{
    unset($_SESSION['filters']);
    unset($_SESSION['min']);
    unset($_SESSION['max']);
}




function retrieveItems()
{
    global $auctionData;
    global $pageLinkNumbers;
    global $selectedPage;

    //Setting the amount of results that should appear per page
    if (isset($_POST['submit-scroll']))
    {
        $results_per_page = $_POST['scrollValue'];
    }
    else
    {
        $results_per_page = 12;
    }


    //if it is the first page and both ranges are set then execute the body
    if(!isset ($_GET['page']) && (isset($_POST['rangePrimary']) && $_POST['rangePrimary'] > 0)  && (isset($_POST['rangeSecondary']) && $_POST['rangeSecondary'] > 0))
    {
        //numbers of result is the returned amount of auction items in the specified range
        $number_of_result = count($auctionData->fetchSpecificCategoryRange($_SESSION['searchedCategory'],htmlentities($_POST['rangePrimary']),htmlentities($_POST['rangeSecondary'])));
        //two session variables are used to keep track of the min and max amount
        $_SESSION['min'] = $_POST['rangePrimary'];
        $_SESSION['max'] = $_POST['rangeSecondary'];
    }
    else if(isset($_POST['filters']))
    {
        //if a filter is selected then number of result will store the amount of rows returned according to the query
        $number_of_result = count($auctionData->fetchSpecificCategory($_SESSION['searchedCategory']));
        //two session variables are used to keep track of the min and max amount
        unset($_SESSION['min']);
        unset($_SESSION['max']);
    }
    //if their is no filter and no min and max search normal else get the count of the category with a range and a filter
    else if (isset($_SESSION['min']) == false && isset($_SESSION['max']) == false)
    {
        $number_of_result = count($auctionData->fetchSpecificCategory($_SESSION['searchedCategory']));
    }
    else
    {
        $number_of_result = count($auctionData->fetchSpecificCategoryRange($_SESSION['searchedCategory'],$_SESSION['min'],$_SESSION['max']));
    }


    //Making a session that contains the results
    $_SESSION['results'] = $number_of_result;

    //determine the total number of pages available
    $number_of_page = ceil($number_of_result / $results_per_page);

    //determine which page number visitor is currently on
    if (!isset ($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
        $selectedPage = $page;
    }

    //determine the sql LIMIT starting number for the results on the displaying page
    $page_first_result = ($page - 1) * $results_per_page;

    //retrieve the selected results from database
    $pageLinkNumbers = $number_of_page;

    //if the filter is set then set a session to keep the filter in every page
    if(isset($_POST['filters']))
    {
        $_SESSION['filters'] = $_POST['filters'];
    }

    //if none of the min and max are set then unset then as the user has not provided a min or max
    if(!isset($_SESSION['min']) && !isset($_SESSION['max']))
    {
        unset($_SESSION['min']);
        unset($_SESSION['max']);
    }

    //if both max and min and the filter is set then execute a certain query depending upon which filter
    if(isset($_SESSION['min']) && isset($_SESSION['max']) && isset($_SESSION['filters']))
    {
        if($_SESSION['filters'] == 'lowToHigh')
        {
            return $auctionData->fetchCategoryPriceLowToHighRange($_SESSION['searchedCategory'], $page_first_result, $results_per_page,$_SESSION['min'],$_SESSION['max']);
        }
        else  if($_SESSION['filters'] == 'highToLow')
        {
            return $auctionData->fetchCategoryPriceHighToLowRange($_SESSION['searchedCategory'], $page_first_result, $results_per_page,$_SESSION['min'],$_SESSION['max']);
        }
    }
    //if the min and max are only set then get the category according to the range
    else if(isset($_SESSION['min']) && isset($_SESSION['max']))
    {
        return $auctionData->fetchSpecificCategoryRange2($_SESSION['searchedCategory'], $_SESSION['min'], $_SESSION['max'], $page_first_result, $results_per_page);
    }
    //if only the filters are set then retrieve results according to which filter has been selected
    else if(isset($_SESSION['filters']) == true)
    {
        if($_SESSION['filters'] == 'lowToHigh')
        {
            return $auctionData->fetchCategoryPriceLowToHigh($_SESSION['searchedCategory'], $page_first_result, $results_per_page);
        }
        else  if($_SESSION['filters'] == 'highToLow')
        {
            return $auctionData->fetchCategoryPriceHighToLow($_SESSION['searchedCategory'], $page_first_result, $results_per_page);
        }
    }
    else
    {
        return $auctionData->fetchCategory($_SESSION['searchedCategory'], $page_first_result, $results_per_page);
    }
}

require_once('Views/displayItems.phtml');