import {countdown} from "./countdown";

(function Auction() {

    let auctions = document.querySelectorAll('.auction');

    let init = function () {
        auctions.forEach(function (element) {

            let countdownBlock = element.querySelector('[data-auction_countdown]');
            countdown(countdownBlock);
        });

    }


    init();

})();

