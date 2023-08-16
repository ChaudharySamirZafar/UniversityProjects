<?php

class Bid implements JsonSerializable {

    protected $_MaxBid, $_userId;

    function __construct($dbRow){

        $this->_MaxBid = $dbRow['BidAmount'];
        $this->_userId = $dbRow['UserLotID'];

    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [
          'MaxBid' => $this->_MaxBid,
          'User' => $this->_userId
        ];
    }
}