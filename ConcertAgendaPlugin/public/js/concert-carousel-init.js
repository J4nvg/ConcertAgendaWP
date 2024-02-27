jQuery(document).ready(function($) {
    $('.concert-seccarousel').owlCarousel({
        center:true,
        nav: true,
        navText: ['', ''],
        loop:false,
        margin:10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
});
jQuery(document).ready(function($) {
    $('.concert-maincarousel').owlCarousel({
        center:true,
        nav: true,
        navText: ['', ''],
        loop:false,
        margin:10,
       items:1
    });
});