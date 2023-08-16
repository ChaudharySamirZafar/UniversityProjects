class lotsNumber {

    /**
     * I have created a static class to interact with the users demand for items viewed each scroll
     * The numbers i have created as default if the user does not pick any numbers
     * these static numbers continue to increment as the user scrolls down
     *
     */
    //Calculates the maximum amount of lots
    static amountOfLots = 0;
    //gets the limit of each scroll
    static limit = 12;
    //calculates how much lots the user wants to see after each scroll
    static lot_offset = 12;
    //calculates what the latest lot the user has seen
    static latestProductNo = 12;
    //an counter to see the latestProduct
    static counter = 13;
    //a counter to calculate the starting limit if the user doesnt select a certain amount
    static startingLimit = 12;

}

//a function for when the user scroll's
window.onscroll = function(ev) {
    //if the scroll is hitting the bottom of the page then execute the body
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight)
    {
        // you're at the bottom of the page#
        //if the user has not viewed all of the lots then display some else console out a message.
            if (lotsNumber.amountOfLots > lotsNumber.latestProductNo)
                loadLots();
            else {
                console.log("No more lots");
                console.log("amount of lots"+lotsNumber.amountOfLots);
                console.log("latestProductNo"+lotsNumber.latestProductNo);
            }
    }
};

//retrieves the amount of lots which is represented in the html by an element
lotsNumber.amountOfLots = document.getElementById('numberOfResults').innerHTML;

//if the user sets the scroll limit to something then execute the body
if (document.getElementById('scrollVal') !== null) {
    //if the limit is higher then 2 and smaller then 151 then change the static values.
    let lotsPerScroll = parseInt(document.getElementById('scrollVal').innerHTML);
    if (lotsPerScroll > 2 && lotsPerScroll < 151 ) {
        lotsNumber.startingLimit = lotsPerScroll;
        lotsNumber.lot_offset = lotsPerScroll;
        lotsNumber.limit = lotsPerScroll;
        lotsNumber.counter = lotsPerScroll+1;
    }
}


/**
 * this function loads lots corresponding to the values of the static classes
 */
function loadLots() {

    //Creating a XMLHttpRequest variable
    let xmlhttp = new XMLHttpRequest();

    //Get the limit and offset that the user has set from the class
    let limit = lotsNumber.limit;
    let offset = lotsNumber.lot_offset;
    //Get the network key from the html elements and given the value to the variable token
    let token = document.getElementById('networkKey').innerHTML;

    //when the request has been processed and is ready
    xmlhttp.onreadystatechange = function () {

        //check if the request was successful and worked then execute the body
        if (this.readyState === 4 && this.status === 200) {
            //lotSection is the container all the lots are displayed in
            let lotArea = document.getElementById('lotSection');
            //increment the latestProductNo and the offset
            lotsNumber.lot_offset += lotsNumber.startingLimit;
            lotsNumber.latestProductNo = lotsNumber.latestProductNo + lotsNumber.startingLimit;


            let jsonData = null;
            //if the response is not equals to not working then parse the response else log "not working"
            if (this.responseText !== 'not working') {
                jsonData = JSON.parse(this.responseText);
            }
            else {
                console.log(this.responseText);
            }

            //an extra if check to check if the data isn't equal to null
            if (jsonData != null) {
                //for each object in the jsonData variable execute the body
                jsonData.forEach(function (obj) {

                    /**
                     * in the body of the for each loop i have
                     * created a lot and stored it in the correct position
                     * i have created relevant information such as lot titles
                     * ,minimum bids, view buttons etc.
                     * the whole of the body just consists of creating and manipulating html elements that get added to the document.
                     */

                    let position = document.createElement('div');
                    position.className = 'col-lg-4 col-md-6 mb-4 mt-5';
                    position.id = "ProductNo" + lotsNumber.counter++;
                    lotArea.appendChild(position);


                    let cardBorder = document.createElement('div');
                    cardBorder.className = 'card h-100 border';
                    position.appendChild(cardBorder);


                    let imageBorder = document.createElement('a');
                    let image = document.createElement('img');
                    image.src = obj.imagePath;
                    image.className = 'card-img-top';
                    imageBorder.appendChild(image);
                    cardBorder.appendChild(imageBorder);

                    let cardBody = document.createElement('div');
                    cardBody.className = 'card-body';

                    cardBorder.appendChild(cardBody);

                    let productName = document.createElement('h5');
                    productName.innerHTML = obj.productName;
                    cardBody.appendChild(productName);

                    let description = document.createElement('p');
                    description.innerHTML = obj.description;

                    cardBody.appendChild(description);

                    let cardFooter = document.createElement('div');
                    cardFooter.className = 'card-footer';

                    cardBorder.appendChild(cardFooter);

                    let endDate = document.createElement('p');
                    let endDateText = " End Date : " + obj.endDate;
                    endDate.innerHTML = endDateText.bold();

                    let startingBid = document.createElement('p');
                    let startingBidText = " Starting Bid : £" + obj.minimumBid;
                    startingBid.innerHTML = startingBidText.bold();

                    cardFooter.appendChild(startingBid);
                    cardFooter.appendChild(endDate);


                    let form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'singleItem.php';

                    cardFooter.appendChild(form);

                    let viewButton = document.createElement('button');
                    viewButton.innerText = "View";
                    viewButton.className = 'btn  rounded-pill btn-custom  text-uppercase';
                    viewButton.type = 'submit';
                    viewButton.name = 'viewBtn';

                    form.appendChild(viewButton)

                    let auctionId = document.createElement('input');
                    auctionId.name = 'auctionID';
                    auctionId.value = obj.itemId;
                    auctionId.style.display = 'none';

                    form.appendChild(auctionId);


                });
            }
        }


    }

    xmlhttp.open('GET', 'AJAX/infiniteScrolling.php?offset=' + offset + '&limit=' + limit + '&token=' + token);
    xmlhttp.send();



}