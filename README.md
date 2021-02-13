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

-  Admin creates a product
-  Admin creates an auction by connecting it to a product

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



# Auction Types
##Absolute
- Bidders will set the auction price. How this works is that by placing a bid, you are saying "I want this product for $$$$", in which case the auction price will be the amount the person bid it
- Each high bid will increase the value of the value of the auction by changing its value to that of the highest bid.

##### How it works
- Auction starts off at $100
- Customer 1 bids at $110
- Auction is now at $110
- Customer 2 bids at $300
- Auctions is now at $300
- etc




## Min Bid
How does this work

auction_current_price = 100 <br/>
min_bid = 10 <br/>
bid_amount = 5 <br />

```
c1_max_bid = 103
Error this is less than the allowed min_bid
```

```
c1_max_bid = 110
since this is the first bid then its fine
auction_current_price = 105
```

```
c1_max_bid = 120
since this is the first bid then its fine
auction_current_price = 105
```


```
c2_max_bid = 108
this is not okay, less than min_bid
```

CASE 1
```
c1_max_bid = 120
c2_max_bid = 115
gets outbid because c1_max_bid
auction_current_price = 115
auction_current_price = 115 + 5  = 120
```

CASE 2
```
auction_current_price = 105
c1_max_bid = 120
c2_max_bid = 119
gets outbid because c1_max_bid
auction_current_price = 119
auction_current_price = 119 + 5  = 124 
This is wrong as the max bid is 120
so we need to make sure that we make it 120
```


```
c1 = 200
c2 = 190

```
