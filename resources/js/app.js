require('./bootstrap');

require('./auction/init');


let options = {
    rootMargin: "-2% 0px 0px 0px",
    threshold: 0.1,
}

const animationObserver = new IntersectionObserver(function (entries) {
    for (const entry of entries) {

        //TODO: separate the img load with a new observer so we can unset it once loaded and not run it again.
        entry.target.classList.toggle('intoView', entry.isIntersecting);


        if (entry.isIntersecting) {

            let _img = entry.target.querySelector('img');
            _img.src = _img.getAttribute('data-src');
            entry.target.setAttribute('src', entry.target.getAttribute('data-src'));
        }


    }
}, options);

for (const element of document.querySelectorAll('.auctionCard')) {
    animationObserver.observe(element);
}
