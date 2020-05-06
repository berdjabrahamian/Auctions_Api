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

##### Create Product
1 - Admin creates a product -> the product must exist before it can be attached to the auction.

##### Create Auction
1. Admin creates an auction by attaching to it a product that isnt assigned to an auction already.

##### Start Bidding
1 - Customer places a max bid on the auctions
  - Customer needs to exist into the system before a max bid can be created
    - Customer doesnt Exist
      - Admin needs to import customers or create them manually one by one
    - Customer Exists
      - If the customer doesnt have the correct permission, then there bids wont go through, and the admin needs to set the proper permission to allow bids to be placed
 
2 - Bid get placed on auction
  - Based on the auction state, when a bid is placed the customer is either notified that they are the highest bidder or they are outbid
 
3 - Based on its status, either the auction ends with a winner (since a bid is placed) or passed (no one placed a bid on the auctions)

4 - Notifications are send out
  - Auction ending soon - to customer who have placed a bid on the auctions
  - Auction won - to the highest bidding customer
  - Auction Lost - to the customers who bid but were outbid

---




##### Email Notifications 
- Max Bid
  - Created
    - When the max bid is created - customers first bid on an auction
  - Updated
    - When the max bid is updated
  - Outbid
    - When the customer is outbid (DONE)

- Auction
  - Ending Soon
    - Send all who have bid its ending soon
  - Extended
    - When going going gone is triggered to all who have bid
  - Winner
    - Send this to the winner of the auction
  - Lost
    - Send to all who lost

##### Events
- MaxBid
   - Created
   - Updated
   - Outbid
- Auction created
  - Auction (without relations)
  
##### Console
- Create Store
Auction state is used to keep track of the state the auction is in, which we use to manage whether there is a winner or a looser


