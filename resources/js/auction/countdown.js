
export function countdown(block) {



    let countdown = document.createElement('div');
    countdown.classList.add('countdown');

    let auctionTimeLeft = document.createElement('div');
    auctionTimeLeft.classList.add('auctionTimeLeft');

    block.appendChild(countdown);
    block.appendChild(auctionTimeLeft);

    setAuctionEndDate(auctionTimeLeft);
    startCountdown(countdown);

}


const timeOptions = {
    weekday: 'short',
    month: 'short',
    day: '2-digit',
    year: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
};


let getTimeRemaining = function (endTime) {
    return endTime - new Date().getTime();
};


let setAuctionEndDate = function (block) {
    block.innerText = new Date(block.parentElement.getAttribute('data-auction_end_date')).toLocaleDateString('en-US', timeOptions);
};

let startCountdown = function (block, update = false) {

    let parent = block.parentElement;
    let now;
    let distance;
    let days, hours, minutes, seconds;
    let instance;
    let time;
    let timeout = 1000;


    if (update) {
        clearInterval(block.getAttribute('timer'));
    }

    let timer = function () {
        now = new Date().getTime();

        // Find the distance between now and the count down date
        // We need to times it by 1000 because JS time runs in milliseconds while the php zend date is giving it in seconds
        distance = (parent.getAttribute('data-auction_countdown') * 1000) - now;

        console.log(distance);
        //Lets not run this and remove all traces of the timer
        if (distance <= 0) {
            if (block.hasAttribute('timer')) {
                clearInterval(block.getAttribute('timer'));
                block.removeAttribute('timer');
                block.classList.remove('ending-soon');
            }

            if (block.parentElement.hasAttribute('has-ended')) {
                if (block.parentElement.hasAttribute('passed')) {
                    block.classList.add('auctionEnded');
                } else if (block.parentElement.hasAttribute('won')) {
                    block.classList.add('auctionWon');
                }
            }

            block.innerHTML = '';

            return;
        }


        // Time calculations for days, hours, minutes and seconds
        days = Math.floor(distance / (1000 * 60 * 60 * 24));
        hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        seconds = Math.floor((distance % (1000 * 60)) / 1000);


        // If less than a day dont show DAY
        let daysText = days >= 1 ? days + 'D ' : '';
        // If less than a hours dont show HOUR
        let hoursText = hours >= 1 ? hours + 'H ' : '0H';
        // If less than 10 minutes or seconds put a 0 in front of it
        let minutesText = minutes >= 10 ? minutes + 'M ' : '0' + minutes + 'M ';
        let secondsText = seconds >= 10 ? seconds + 'S ' : '0' + seconds + 'S';


        time = {days: daysText, hours: hoursText, minutes: minutesText, seconds: secondsText};

        if (days >= 1) {
            block.innerHTML = time.days + time.hours;
        } else {
            if (hours >= 1) {
                block.innerHTML = time.hours + time.minutes;
            } else if (hours == 0) {
                block.innerHTML = time.minutes + time.seconds;
            }
        }

        // I believe this is 15 min - this is all in epoch time
        if (distance <= 600000) {
            block.classList.add('ending-soon');
        } else {
            block.classList.remove('ending-soon');
        }

    };

    timer();

    instance = setInterval(timer, timeout);
    block.setAttribute('timer', instance);
};
