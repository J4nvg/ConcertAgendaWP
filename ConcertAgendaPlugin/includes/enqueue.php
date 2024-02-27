<?php
// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

function concert_enqueue_owl_carousel() {
    // Enqueue Owl Carousel CSS
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-theme-default', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_style('concertheaderstyle-css', plugins_url('public/css/concertheaderstyle.css', dirname(__FILE__)));
    wp_enqueue_style('concert-carousel-custom-css', plugins_url('public/css/concert-carousel-custom.css', dirname(__FILE__)));
    // Enqueue Owl Carousel JavaScript
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    
    // Your custom script to initialize Owl Carousel
    wp_enqueue_script('concert-owl-carousel-init', plugins_url('public/js/concert-carousel-init.js', dirname(__FILE__)), array('jquery', 'owl-carousel-js'), null, true);
}
add_action('wp_enqueue_scripts', 'concert_enqueue_owl_carousel');
