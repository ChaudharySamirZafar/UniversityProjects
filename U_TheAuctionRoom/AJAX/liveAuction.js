//If the user has more placed a bid on 1 or more items then execute the body
if (document.getElementById('numberOfLots').innerHTML > 0) {
    //call the liveAuction every 1500s
    window.setInterval(liveAuction, 1500);
    window.setInterval(updateTime,5);
}

function updateTime(){

    const d = new Date();
    const h = d.getHours();
    const m = d.getMinutes();
    const s = d.getSeconds();
    const secondsUntilEndOfDate = (24 * 60 * 60) - (h * 60 * 60) - (m * 60) - s;
    const currentTime = new Date(secondsUntilEndOfDate * 1000).toISOString().substr(11, 8)

    for (let i =0; i < document.getElementById('numberOfLots').innerHTML; i++) {
        document.getElementById('countDown'+i).innerHTML = " " + currentTime;
    }
}


function liveAuction() {

    //An array to store the lot ids
    let lotsArray = [];

    //a for loop to retrieve all of the auction lot items the user has placed a bid on
    for (let i = 0; i < document.getElementById('numberOfLots').innerHTML; i++) {
        //a dynamic variable to keep getting every lots name
        //increment fashion
        let lotName = 'auctionID' + i;
        //stores the id of the lot in the array
        lotsArray[i] = document.getElementById(lotName).value;
    }

    // a array to store the bid values of a user on the current items
    let bidValues = [];
    //if the numberOfLots is not equal to null
    //then execute the body
    if (document.getElementById('numberOfLots') !== null) {

        //for loop to iterate through the bidValues of each lot
        //gets the bid the user has placed on each item
        for (let i = 0; i < document.getElementById('numberOfLots').innerHTML; i++) {
            let bidValue = document.getElementById('bidNo' + i).innerText;
            bidValues[i] = parseInt(bidValue.slice(12));
        }
    }

    //getting the key from the html
    let token = document.getElementById('networkKey').innerHTML;

    //make a new XMLHttpRequest variable
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {

        //if the status is done and ready then execute the body
        if (this.readyState === 4 && this.status === 200) {
            //write code of what to do once the information is sent back

            let jsonData = null;
            //if the response text is not equals to not working then parse the data
            //else print not working to the console
            if (this.responseText !== 'not working') {
                jsonData = JSON.parse(this.responseText);
            }
            else {
                console.log(this.responseText);
            }

            // a variable to track what item we are referring to in the users bid list
            let bidCount = 0;

            //if the jsonData is not null then execute the body
            if (jsonData !== null) {
                //a for each loop to iterate through the JSONs objects
                jsonData.forEach(function (obj) {
                    //retrieves the max bid of a item from the json object
                    let maxBid = obj.MaxBid;

                    //if the maxBid on the item is larger then what the current user has bidded on then execute the body
                    if (maxBid > bidValues[bidCount]) {

                        //if the winningBid is equals to null then render the losing card
                        //else update the maxBid
                        if (document.getElementById('winningBid' + bidCount) == null) {

                            let bidVal = document.getElementById('bidNo' + bidCount);
                            bidVal.style.color = "Red";

                            let div = document.getElementById('cardFooterNo' + bidCount);

                            let winningBid = document.createElement('p');
                            winningBid.id = "winningBid" + bidCount;
                            let winningBidText = "Winning Bid : £" + maxBid;
                            winningBid.innerHTML = winningBidText.bold();

                            winningBid.style.color = "LightGreen";
                            div.appendChild(winningBid);

                            let LotAlert = document.getElementById('alertNo' + bidCount);
                            LotAlert.className = 'alert alert-danger text-center';

                            let alertInnerText = LotAlert.children[0];
                            alertInnerText.className = 'fa fa-exclamation-circle';
                            alertInnerText.innerHTML = " You are losing this auction ";


                        }
                        else if (document.getElementById('winningBid' + bidCount) !== null) {

                            let currentWinning = document.getElementById('winningBid' + bidCount);
                            let winningBid = currentWinning.innerHTML;
                            winningBid = winningBid.slice(16);

                            if (winningBid !== maxBid) {
                                let winningBidText = "Winning Bid : £" + maxBid;
                                currentWinning.innerHTML = winningBidText.bold();
                            }
                        }

                    }

                    //increment the counter
                    bidCount++;
                });
            }


        }

    }


    // xmlhttp.open("POST", "AJAX/LiveAuction.php?token=" + "s", true);
    // xmlhttp.setRequestHeader("Content-Type", "application/json");
    // xmlhttp.send(JSON.stringify(lotsArray));

    //sending the token to the ajax script
    xmlhttp.open('GET','AJAX/LiveAuction.php?lotsArray=' + JSON.stringify(lotsArray) +"&token=" + token, true);
    xmlhttp.send();
}

