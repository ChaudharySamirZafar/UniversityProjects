<?php

class AuctionData {

    protected $_id, $_startDate, $_endDate;

    function __construct($dbRow){
        $this->_id = $dbRow['AuctionID'];
        $this->_startDate = $dbRow['StartDate'];
        $this->_endDate = $dbRow['EndDate'];
    }

    /**
     * @return int
     * accessor method for _id
     */
    public function getID()
    {
        return $this->_id;
    }

    /**
     * @return string
     * accessor method for _startDate
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * @return string
     * accessor method for _endDate
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }
}

