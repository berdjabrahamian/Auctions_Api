require('./bootstrap');

require('./auction/init');



//Image Loading Observer For Lazy Loading
const imageLoadObserver = new IntersectionObserver(function(entries) {
    for (const entry of entries) {
        if (entry.isIntersecting) {

            let _img = entry.target;
            _img.src = _img.getAttribute('data-src');
            _img.setAttribute('src', entry.target.getAttribute('data-src'));

            imageLoadObserver.unobserve(entry.target);

        }

    }
}, {
    rootMargin: '10px 0px 10px 0px',
    threshold: 1,
});

document.querySelectorAll('img').forEach(function(image) {
    imageLoadObserver.observe(image);
});



//Auction Card Observer to bring in and out of the viewport
const animationObserver = new IntersectionObserver(function (entries) {
    for (const entry of entries) {
        //TODO: separate the img load with a new observer so we can unset it once loaded and not run it again.
        entry.target.classList.toggle('intoView', entry.isIntersecting);
    }
}, {
    rootMargin: "-20px 0px -20px 0px",
    threshold: 0.1,});

document.querySelectorAll('.auctionCard').forEach(function(element){
    animationObserver.observe(element);
});
