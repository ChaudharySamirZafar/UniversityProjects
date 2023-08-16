<?php
include_once("AuctionData.php");

class AuctionItemData extends AuctionData implements JsonSerializable {

    protected $_imagePath, $_productName, $_description, $_title, $_endDate, $_minimumBid,$_itemIndividualID,$_startDate,$_userId;

    function __construct($dbRow){

        $this->_imagePath = $dbRow['imagePath'];
        $this->_productName = $dbRow['ProductName'];
        $this->_title = $dbRow['Title'];
        $this->_description = $dbRow['Description'];
        $this->_minimumBid = $dbRow['MinimumBid'];
        $this->_itemIndividualID = $dbRow['AuctionItemID'];
        $this->_userId = $dbRow['UserID'];
        parent::__construct($dbRow);
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.

        return [
            'productName' => $this->_productName,
            'imagePath' => $this->_imagePath,
            'endDate' => $this->_endDate,
            'description' => $this->_description,
            'minimumBid' => $this->_minimumBid,
            'title' => $this->_title,
            'itemId' => $this->_itemIndividualID,
            'startDate' => $this->_startDate,
            'userId' => $this->_userId,
        ];

    }

    /**
     * @return string
     * returns the items imagePath
     */
    public function getImagePath()
    {
        return $this->_imagePath;
    }

    /**
     * @return string
     * returns the items name
     */
    public function getProductName()
    {
        return $this->_productName;
    }

    /**
     * @return string
     * returns the items description
     */
    public function getProductDescription()
    {
        return $this->_description;
    }

    /**
     * @return string
     * returns the items title
     */
    public function getProductTitle()
    {
        return $this->_title;
    }

    /**
     * @return string
     * returns the items endDate
     */
    public function getEndDate(){
        return $this->_endDate;
    }

    /**
     * @return int
     * returns the items minimum bid
     */
    public function getMinimumBid(){
        return $this->_minimumBid;
    }

    /**
     * @return int
     * returns the items id
     */
    public function getItemID(){
        return $this->_itemIndividualID;
    }

    /**
     * @return string
     * returns the items startDate
     */
    public function getStartDate(){
        return $this->_startDate;
    }

    /**
     * @return int
     * returns the items owners id
     */
    public function getUserID(){
        return $this->_userId;
    }

}