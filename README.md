<h1 align="center">Auctions Api</h1>
<p align="center">Auctions Api platform built on top of Laravel</p>

### About this project
This system will house the API and all logic needed to run a auctions system. Seeing as this is a api, you can integrate this into any frontend you desire, current and future builds.

This will be built with multi-tenecy in mind, which means you can host this api in one location, but have multiple users consume this API.


#### How Does It Work
There are 2 ways of approaching this system. Either through your own frontend/backend or through the admin panel that comes with this api.
Each method will have its own set of instructions on what needs to be done.

---

##### I want to use my own system
**_coming soon_**

---

##### I want to use the admin panel
**_coming soon_**

---

#### How does it work
##### Create Auction
1. Admin creates a product - or it will be created during the auction creation process
2. Admin turn that product into a auction


##### Placing Bids
1. Customer places bid on auction
2. And based on the state will determined if its accepted or been outbid
3. If the bid is placed withing the ending threshold (going-going-gone), we will extend the auction end time


##### Email Notifications 
- Max Bid (todo)
  - Created
    - When the max bid is created - customers first bid on an auction
  - Updated
    - When the max bid is updated
  - Outbid
    - When the customer is outbid (DONE)

- Auction (todo)
  - Ending Soon
    - Send all who have bid its ending soon
  - Extended
    - When going going gone is triggered to all who have bid
  - Winner
    - Send this to the winner of the auction
  - Lost
    - Send to all who lost

##### Events
- Auction created
  - Auction (without relations)
  
##### Console
- Create Store
Auction state is used to keep track of the state the auction is in, which we use to manage whether there is a winner or a looser


