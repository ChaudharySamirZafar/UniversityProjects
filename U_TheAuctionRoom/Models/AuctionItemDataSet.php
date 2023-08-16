<?php
require_once('Database.php');
require_once('AuctionItemData.php');
require_once('AuctionData.php');
require_once('Bid.php');

class AuctionItemDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $category
     * @return array
     * searches through the database according to a category given by the user
     */
    public function fetchSpecificCategory($category)
    {
        $liveAuction = date("Y-m-d");

        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
        Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,
        Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemId = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItems.Category LIKE ? AND Auctions.StartDate = '" . $liveAuction . "'
        group by (Images.AuctionLotImageID)";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];


        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);

        }

        return $dataset;
    }

    /**
     * @param $category
     * @param $lowRange
     * @param $highRange
     * @return array
     * searches through the database according to a category given by the user a
     * sets a price range with lowRange and highRange
     */
    public function fetchSpecificCategoryRange($category, $lowRange, $highRange)
    {
        $liveAuction = date("Y-m-d");
        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
        Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,
        Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemId = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItems.Category LIKE ? AND Auctions.StartDate = '" . $liveAuction . "'
        AND AuctionItems.MinimumBid >= ?
        AND AuctionItems.MinimumBid <= ?
        group by (Images.AuctionLotImageID)";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2,$lowRange,$highRange));
        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);
        }

        return $dataset;
    }


    /**
     * @param $category
     * @param $lowRange
     * @param $highRange
     * @param $offset
     * @param $limit
     * @return array
     * search through the database and returns auction items that are in the range of lowRange and highRange with
     * a offset and limit
     * uses offset and limit to allow pagination
     */
    public function fetchSpecificCategoryRange2($category, $lowRange, $highRange, $offset, $limit)
    {
        $liveAuction = date("Y-m-d");
        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
        Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemId = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItems.Category LIKE ? AND Auctions.StartDate = '" . $liveAuction . "'
        AND AuctionItems.MinimumBid >= '$lowRange'
        AND AuctionItems.MinimumBid <= '$highRange'
        group by (Images.AuctionLotImageID) LIMIT  " . $limit . " OFFSET " . $offset . " ";


        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];

        $i = 0;
        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);
        }

        return $dataset;
    }

    /**
     * @param $category
     * @param $offset
     * @param $limit
     * @return array
     * fetches a certain category that is live
     * uses offset and limit to allow pagination
     */
    public function fetchCategory($category, $offset, $limit)
    {


        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
        Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,Auctions.AuctionID
        FROM aee363.AuctionItems 
        JOIN aee363.Images ON  AuctionItems.AuctionItemId = Images.AuctionLotImageID 
        JOIN aee363.Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItems.Category LIKE '%$category%' AND Auctions.StartDate = '" . $liveAuction . "'
		group by (Images.AuctionLotImageID) LIMIT  " . $limit . " OFFSET " . $offset . " ";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);
        }

        return $dataset;



    }

    /**
     * @param $category
     * @param $offset
     * @param $limit
     * @return array
     * searches through the database to return all auction item that match the category
     * and applied offset and limit for pagination
     * returns in ASC order
     */
    public function fetchCategoryPriceLowToHigh($category, $offset, $limit)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) 
        AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, Auctions.EndDate, 
        AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.AuctionID,
        Auctions.StartDate,AuctionItems.UserID FROM AuctionItems 
        JOIN Images ON AuctionItems.AuctionItemId = Images.AuctionLotImageID JOIN Auctions 
        ON AuctionItems.AuctionID = Auctions.AuctionID WHERE AuctionItems.Category LIKE ? AND 
        Auctions.StartDate = '" . $liveAuction . "' group by (Images.AuctionLotImageID) ORDER BY AuctionItems.MinimumBid ASC LIMIT  " . $limit . " OFFSET " . $offset . " ";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);

        }
        return $dataset;
    }

    /**
     * @param $category
     * @param $offset
     * @param $limit
     * @param $lowRange
     * @param $highRange
     * @return array
     * search through the database and returns all auction items between the range
     * the results are returned in an ascending order
     */
    public function fetchCategoryPriceLowToHighRange($category, $offset, $limit, $lowRange, $highRange)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) 
        AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, Auctions.EndDate, 
        AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.AuctionID,
        Auctions.StartDate,AuctionItems.UserID FROM AuctionItems 
        JOIN Images ON AuctionItems.AuctionItemId = Images.AuctionLotImageID JOIN Auctions 
        ON AuctionItems.AuctionID = Auctions.AuctionID WHERE AuctionItems.Category LIKE ? AND 
        Auctions.StartDate = '" . $liveAuction . "' 
        AND AuctionItems.MinimumBid >=  '$lowRange' 
        AND AuctionItems.MinimumBid <= '$highRange'
        group by (Images.AuctionLotImageID) ORDER BY AuctionItems.MinimumBid ASC LIMIT  " . $limit . " OFFSET  " . $offset . " ";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);

        }
        return $dataset;
    }

    /**
     * @param $category
     * @param $offset
     * @param $limit
     * @return array
     * searches through the database to return all auction item that match the category
     * and applied offset and limit for pagination
     * returns in DESC order
     */
    public function fetchCategoryPriceHighToLow($category, $offset, $limit)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) 
        AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, Auctions.EndDate, 
        AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.AuctionID,
        Auctions.StartDate,AuctionItems.UserID FROM AuctionItems 
        JOIN Images ON AuctionItems.AuctionItemId = Images.AuctionLotImageID JOIN Auctions 
        ON AuctionItems.AuctionID = Auctions.AuctionID WHERE AuctionItems.Category LIKE ? AND 
        Auctions.StartDate = '" . $liveAuction . "' group by (Images.AuctionLotImageID) ORDER BY AuctionItems.MinimumBid DESC LIMIT  " . $limit . " OFFSET  " . $offset . " ";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);

        }
        return $dataset;
    }

    /**
     * @param $category
     * @param $offset
     * @param $limit
     * @param $lowRange
     * @param $highRange
     * @return array
     * search through the database and returns all auction items between the range
     * the results are returned in an descending order
     */
    public function fetchCategoryPriceHighToLowRange($category, $offset, $limit, $lowRange, $highRange)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) 
        AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, Auctions.EndDate, 
        AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.AuctionID,
        Auctions.StartDate,AuctionItems.UserID FROM AuctionItems 
        JOIN Images ON AuctionItems.AuctionItemId = Images.AuctionLotImageID JOIN Auctions 
        ON AuctionItems.AuctionID = Auctions.AuctionID WHERE AuctionItems.Category LIKE ? AND 
        Auctions.StartDate = '" . $liveAuction . "' 
        AND AuctionItems.MinimumBid >= '$lowRange' 
        AND AuctionItems.MinimumBid <= '$highRange'
        group by (Images.AuctionLotImageID) ORDER BY AuctionItems.MinimumBid DESC LIMIT  " . $limit . " OFFSET  " . $offset . " ";

        $category2 = "%" . $category . "%";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($category2));
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);

        }
        return $dataset;
    }


    /**
     * @return array
     * a function that pulls all available data for auctions from the database
     * returns an array for the controller to pass onto the view
     * which displays all of the auction dates
     */
    public function retrieveAllAuctionDates()
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT StartDate FROM Auctions WHERE StartDate > '" . $liveAuction . "'  ";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];
        $i = 0;
        while ($row = $statement->fetch()) {
            $dataset[$i] = $row[0];
            $i++;
        }

        return $dataset;
    }

    /**
     * @param $auction
     * @param $userID
     * @param $ProductName
     * @param $ProductTitle
     * @param $Category
     * @param $ProductDescription
     * @param $ProductMinimumBid
     * @param $ImagePath
     * lists an item in the AuctionData table in the database
     * takes all values that are needed for Images table aswell
     */
    public function listItem($auction, $userID, $ProductName, $ProductTitle, $Category, $ProductDescription, $ProductMinimumBid, $ImagePath)
    {

        //First i will retrieve the auction they want to input their item in
        $sqlQuery = "SELECT AuctionID FROM Auctions WHERE StartDate = '" . $auction . "'  ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $auctionID = 0;

        while ($row = $statement->fetch()) {
            $auctionID = $row[0];
        }

        //Secondly add the data as a individual item/lot
        $sqlQuery = "INSERT INTO AuctionItems (UserID, AuctionID, ProductName, Title, Description, Category, MinimumBid) VALUES(?,?,?,?,?,?,?)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($userID,$auctionID,$ProductName,$ProductTitle,$ProductDescription,$Category,$ProductMinimumBid));

        //receive the products ID that you have just added
        $sqlQuery = "SELECT AuctionItemID FROM AuctionItems WHERE Description = '" . $ProductDescription . "' ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $itemID = 0;
        while ($row = $statement->fetch()) {
            $itemID = $row[0];
        }

        //Finally add the image to the image table
        foreach ($ImagePath as $individualImage) {
            $sqlQuery = "INSERT INTO Images (AuctionLotImageID, ImagePath) VALUES (?,?)";
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->execute(array($itemID,$individualImage));
        }
    }


    /**
     * returns a users items that are currently listed
     * currently listed meaning they are listed on that particular day
     * @param $userID
     * @return array
     */
    public function retrieveUsersCurrentListing($userID)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
       Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemID = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE Auctions.StartDate ='" . $liveAuction . "' AND AuctionItems.UserID = '" . $userID . "'
        group by (Images.AuctionLotImageID)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);
        }

        return $dataset;
    }

    /**
     * returns a users items that are listed in the future
     * @param $userID
     * @return array
     */
    public function retrieveUsersFutureListing($userID)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, 
       AuctionItems.Title, Auctions.EndDate, AuctionItems.MinimumBid, 
       Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemID = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE Auctions.StartDate > '" . $liveAuction . "' AND AuctionItems.UserID = '" . $userID . "'
        group by (Images.AuctionLotImageID)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionItemData($row);
        }

        return $dataset;
    }

    /**
     * @param $auctionItemID
     * @return $dataset
     * fetches information for the individual item and returns it for the controller to use and view to display
     */
    public function fetchIndividualItem($auctionItemID)
    {

        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
       Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate,AuctionItems.UserID,Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemID = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItems.AuctionItemID = '" . $auctionItemID . "' group by (Images.AuctionLotImageID)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = null;

        while ($row = $statement->fetch()) {
            $dataset = new AuctionItemData($row);
        }

        return $dataset;
    }

    /**
     * @param $auctionItemID
     * @return int|mixed
     * retrieves the maximum bid amount of the particular item
     */
    public function getMaxBid($auctionItemID)
    {
        $sqlQuery = "SELECT max(BidAmount) FROM Bids WHERE AuctionLotID = '" . $auctionItemID . "' ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = 0;


        //echo "Getting Max Bids";


        while ($row = $statement->fetch()) {
            $dataset = $row[0];
            //echo $row[0];
        }

        return $dataset;
    }

    /**
     * @param $auctionItemID
     * @return array
     * fetches all of the image paths for the inidividual item
     */
    public function fetchAllImages($auctionItemID)
    {
        $sqlQuery = "SELECT Images.ImagePath FROM Images WHERE Images.AuctionLotImageID = '" . $auctionItemID . "' ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataset = [];

        $i = 0;
        while ($row = $statement->fetch()) {
            $dataset[$i] = $row[0];
            $i++;
        }

        return $dataset;
    }

    /**
     * @param $auctionItemId
     * @param $userID
     * @param $bidAmount
     * allows a user to place a bid
     * enters all of the bid information into the Bids table
     */
    public function placeBid($auctionItemId, $userID, $bidAmount)
    {
        $sqlQuery = "INSERT INTO Bids (AuctionLotID, UserLotID, BidAmount) VALUES
        (?,?,?)  ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($auctionItemId,$userID,$bidAmount));
    }


    /**
     * @param $userId
     * @return array
     * takes a user id
     * searches for current bids that are live matching that bid
     */
    public function getUsersBids($userId)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT  distinct Bids.AuctionLotID FROM Bids
	    JOIN AuctionItems ON AuctionItemID = Bids.AuctionLotID
        JOIN Auctions ON Auctions.AuctionID = AuctionItems.AuctionID
        where Bids.UserLotID = ? AND Auctions.StartDate =  '" . $liveAuction . "' ";



        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($userId));
        $dataset = [];
        $i = 0;

        while ($row = $statement->fetch()) {
            $dataset[$i] = $row[0];
            $i++;
        }

        return $dataset;
    }

    /**
     * @param $lotID
     * @param $userID
     * @return int|mixed
     * retrieves the maximum bid an user has placed on a certain item
     */
    public function getUsersMaxBids($lotID, $userID)
    {
        $sqlQuery = "SELECT Max(BidAmount) FROM Bids WHERE AuctionLotID = ? AND UserLotID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($lotID,$userID));
        $dataset = 0;

        while ($row = $statement->fetch()) {
            $dataset = $row[0];
        }

        return $dataset;
    }

    /**
     * @param $lotID
     * @return AuctionItemData|int
     * gets a individual item/lot accorinding to a given item id
     */
    public function getLot($lotID)
    {

        $sqlQuery = "SELECT min(Images.ImagePath) AS imagePath, AuctionItems.ProductName , AuctionItems.Description, AuctionItems.Title, 
       Auctions.EndDate, AuctionItems.MinimumBid, Images.AuctionLotImageID, AuctionItems.Category, AuctionItems.AuctionItemID, Auctions.StartDate, AuctionItems.UserID,Auctions.AuctionID
        FROM AuctionItems 
        JOIN Images ON  AuctionItems.AuctionItemId = Images.AuctionLotImageID 
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID 
        WHERE AuctionItemID = ?
        group by (Images.AuctionLotImageID);";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($lotID));
        $dataset = 0;
        while ($row = $statement->fetch()) {
            $dataset = new AuctionItemData($row);
        }

        return $dataset;
    }

    /**
     * @param $userId
     * @return array
     * retrieves all of the users previous bids
     * previous bids are all bids which has been concluded before the current date
     */
    public function getUsersPreviousBids($userId)
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT  distinct Bids.AuctionLotID FROM Bids
	    JOIN AuctionItems ON AuctionItemID = Bids.AuctionLotID
        JOIN Auctions ON Auctions.AuctionID = AuctionItems.AuctionID
        where Bids.UserLotID = ? AND Auctions.StartDate <  '" . $liveAuction . "' ";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($userId));
        $dataset = [];
        $i = 0;
        while ($row = $statement->fetch()) {
            $dataset[$i] = $row[0];
            $i++;
        }

        return $dataset;
    }

    /**
     * @param $auctionID
     * deletes a auctionItem
     * deletes images and bids for the auction item
     */
    public function deleteAuction($auctionID)
    {
        $sqlQuery = "DELETE FROM Images WHERE Images.AuctionLotImageID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($auctionID));

        $sqlQuery = "DELETE FROM Bids WHERE Bids.AuctionLotID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($auctionID));

        $sqlQuery = "DELETE FROM AuctionItems WHERE AuctionItems.AuctionItemID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($auctionID));
    }

    /**
     * @return array
     * retrieves all auctions date from the Auctions table
     */
    public function retrieveAllAuctionData()
    {
        $liveAuction = date("Y/m/d");
        $sqlQuery = "SELECT * FROM Auctions ";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];

        while ($row = $statement->fetch()) {
            $dataset[] = new AuctionData($row);
        }

        return $dataset;
    }

    /**
     * @param $id
     * deletes an whole auction
     * deletes auction items from that auction and the bids and images for them
     */
    function removeAuction($id)
    {
        $sqlQuery = "DELETE Images FROM Images
        JOIN AuctionItems ON AuctionItems.AuctionItemID = Images.AuctionLotImageID
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID
        Where Auctions.AuctionID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($id));

        $sqlQuery = "DELETE Bids FROM Bids
        JOIN AuctionItems ON AuctionItems.AuctionItemID = Bids.AuctionLotID
        JOIN Auctions ON AuctionItems.AuctionID = Auctions.AuctionID
        Where Auctions.AuctionID = ? ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($id));

        $sqlQuery = "DELETE FROM AuctionItems WHERE AuctionID = ? ; ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($id));

        $sqlQuery = "DELETE FROM Auctions WHERE AuctionID =  ?  ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($id));

    }

    /**
     * @return mixed|null
     * gets the latest date an auction is held in the database
     * used for the admin
     */
    function getLatestDate()
    {
        $sqlQuery = "select max(Auctions.StartDate) from Auctions;";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = null;

        while ($row = $statement->fetch()) {
            $dataset = $row[0];
        }

        return $dataset;
    }

    /**
     * @param $startDate
     * inserts auction start date and endDate into the auctions
     */
    function insertAuction($startDate)
    {
        $next_date = date('Y-m-d', strtotime($startDate . '+1 day'));

        $sqlQuery = "INSERT INTO Auctions (Auctions.StartDate, Auctions.EndDate) VALUE (?,'" . $next_date . "')";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(array($startDate));
    }

    function fetchBid($arrayOfIDs){

        $dataset = [];

        for ($i = 0; $i<sizeof($arrayOfIDs); $i++)
        {
            $sqlQuery = "SELECT UserLotID, BidAmount FROM aee363.Bids where AuctionLotID = $arrayOfIDs[$i]";
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->execute();

            while ($row = $statement->fetch()) {
                $dataset[$i] = new Bid($row);
            }
        }

        return $dataset;

    }
}
