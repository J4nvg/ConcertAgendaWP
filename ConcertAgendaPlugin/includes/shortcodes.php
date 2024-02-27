<?php
 // Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}
function concert_carousel_shortcode($atts) {
    concert_enqueue_owl_carousel(); // Make sure Owl Carousel assets are loaded

    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'meta_value',
        'meta_key' => 'concert_datum',
    ), $atts, 'concert_carousel');

    $current_date = date('Y-m-d');

    $args = array(
        'post_type' => 'concert',
        'posts_per_page' => $atts['posts_per_page'],
        'meta_key' => $atts['meta_key'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        // Add a meta_query to filter posts with concert_datum today or in the future
        'meta_query' => array(
            array(
                'key' => 'concert_datum',
                'value' => $current_date,
                'compare' => '>=', // Greater than or equal to today's date
                'type' => 'DATE' // Ensure the comparison is done date-wise
            )
        ),
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        $output = '<div class="owl-carousel concert-carousel concert-seccarousel owl-theme">';

        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id = get_the_ID();
            $concert_datum = get_post_meta($post_id, 'concert_datum', true);
            $concert_locatie = get_post_meta($post_id, 'concert_locatie', true);
            $format_concert_datum = date_i18n('j F, Y', strtotime($concert_datum));
            $content = strip_tags(get_the_content()); // Remove all HTML tags
            $trimmed_content = mb_substr($content, 0, 197) . '...'; // Trim to the first 197 characters

            $output .= '<div class="card">'; // Start of card
            if (has_post_thumbnail()) {
                $output .= '<div class="card-image">' . get_the_post_thumbnail($post_id, 'full') . '</div>';
            } else {
               
                $fallback_image_url = get_option('concert_fallback_image', plugins_url('public/img/fallback.jpg', dirname(__FILE__)));
                //$fallback_image_url =  plugins_url('.../public/img/fallback.jpg', __FILE__);
                $output .= '<div class="card-image"><img src="' . esc_url($fallback_image_url) . '" alt="Fallback Image"></div>';
            }
            $output .= '<div class="card-body">';
            $output .= '<h3 class="card-title">' . get_the_title() . '</h3>';
            $output .= '<div class="card-text"><p>Concert datum: ' . esc_html($format_concert_datum) . '</p>';
            if (!empty($concert_locatie)) {
                $output .= '<p>Locatie: ' . esc_html($concert_locatie) . '</p>';
            }
            $output .= '</div>';
            $output .= '<p>' . esc_html($trimmed_content)  . '...</p>';
            $output .= '<a href="' . get_permalink() . '" class="card-link">Lees meer</a>';
            $output .= '</div>'; // End of card body
            $output .= '</div>'; // End of card
        }
        $output .= '<div class="owl-nav"></div>'; // End of nav
        $output .= '</div>'; // End of carousel
        wp_reset_postdata();
    } else {
        $output = '<p>Geen concerten gevonden</p>';
    }

    return $output;
}
add_shortcode('concert_carousel', 'concert_carousel_shortcode');

function concert_maincarousel_shortcode($atts) {
    concert_enqueue_owl_carousel(); // Make sure Owl Carousel assets are loaded

    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'meta_value',
        'meta_key' => 'concert_datum',
    ), $atts, 'concert_carousel');

    $current_date = date('Y-m-d');

    $args = array(
        'post_type' => 'concert',
        'posts_per_page' => $atts['posts_per_page'],
        'meta_key' => $atts['meta_key'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        // Add a meta_query to filter posts with concert_datum today or in the future
        'meta_query' => array(
            array(
                'key' => 'concert_datum',
                'value' => $current_date,
                'compare' => '>=', // Greater than or equal to today's date
                'type' => 'DATE' // Ensure the comparison is done date-wise
            )
        ),
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        $output = '<div class="owl-carousel concert-maincarousel concert-carousel owl-theme">';

        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id = get_the_ID();
            $concert_datum = get_post_meta($post_id, 'concert_datum', true);
            $concert_locatie = get_post_meta($post_id, 'concert_locatie', true);
            $format_concert_datum = date_i18n('j F, Y', strtotime($concert_datum));

            $content = strip_tags(get_the_content()); // Remove all HTML tags
            $trimmed_content = mb_substr($content, 0, 197) . '...'; // Trim to the first 197 characters



            $output .= '<div class="card">'; // Start of card
            if (has_post_thumbnail()) {
                $output .= '<div class="card-image">' . get_the_post_thumbnail($post_id, 'full') . '</div>';
            } else {
                $fallback_image_url = get_option('concert_fallback_image', plugins_url('public/img/fallback.jpg', dirname(__FILE__)));
                //$fallback_image_url =  plugins_url('.../public/img/fallback.jpg', __FILE__);
                $output .= '<div class="card-image"><img src="' . esc_url($fallback_image_url) . '" alt="Fallback Image"></div>';
            }
            $output .= '<div class="card-body">';
            $output .= '<h3 class="card-title">' . get_the_title() . '</h3>';
            $output .= '<div class="card-text"><p>Concert datum: ' . esc_html($format_concert_datum) . '</p>';
            if (!empty($concert_locatie)) {
                $output .= '<p>Locatie: ' . esc_html($concert_locatie) . '</p>';
            }
            $output .= '</div>';
            $output .= '<p>' . esc_html($trimmed_content)  . '...</p>';
            $output .= '<a href="' . get_permalink() . '" class="card-link">Lees meer</a>';
            $output .= '</div>'; // End of card body
            $output .= '</div>'; // End of card
        }
        $output .= '<div class="owl-nav"></div>'; // End of nav
        $output .= '</div>'; // End of carousel
        wp_reset_postdata();
    } else {
        $output = '<p>Geen concerten gevonden</p>';
    }

    return $output;
}
add_shortcode('concert_maincarousel', 'concert_maincarousel_shortcode');

function concert_pastcarousel_shortcode($atts) {
    concert_enqueue_owl_carousel(); // Make sure Owl Carousel assets are loaded

    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
        'order' => 'DESC',
        'orderby' => 'meta_value',
        'meta_key' => 'concert_datum',
    ), $atts, 'concert_carousel');

    $current_date = date('Y-m-d');

    $args = array(
        'post_type' => 'concert',
        'posts_per_page' => $atts['posts_per_page'],
        'meta_key' => $atts['meta_key'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        // Add a meta_query to filter posts with concert_datum today or in the future
        'meta_query' => array(
            array(
                'key' => 'concert_datum',
                'value' => $current_date,
                'compare' => '<', // Greater than or equal to today's date
                'type' => 'DATE' // Ensure the comparison is done date-wise
            )
        ),
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        $output = '<div class="owl-carousel concert-carousel concert-seccarousel owl-theme">';

        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id = get_the_ID();
            $concert_datum = get_post_meta($post_id, 'concert_datum', true);
            $concert_locatie = get_post_meta($post_id, 'concert_locatie', true);
            $format_concert_datum = date_i18n('j F, Y', strtotime($concert_datum));
            $content = strip_tags(get_the_content()); // Remove all HTML tags
            $trimmed_content = mb_substr($content, 0, 197) . '...'; // Trim to the first 197 characters



            $output .= '<div class="card">'; // Start of card
            if (has_post_thumbnail()) {
                $output .= '<div class="card-image">' . get_the_post_thumbnail($post_id, 'full') . '</div>';
            } else {
                $fallback_image_url = get_option('concert_fallback_image', plugins_url('public/img/fallback.jpg', dirname(__FILE__)));
                //$fallback_image_url =  plugins_url('.../public/img/fallback.jpg', __FILE__);
                $output .= '<div class="card-image"><img src="' . esc_url($fallback_image_url) . '" alt="Fallback Image"></div>';
            }
            $output .= '<div class="card-body">';
            $output .= '<h3 class="card-title">' . get_the_title() . '</h3>';
            $output .= '<div class="card-text"><p>Concert datum: ' . esc_html($format_concert_datum) . '</p>';
            if (!empty($concert_locatie)) {
                $output .= '<p>Locatie: ' . esc_html($concert_locatie) . '</p>';
            }
            $output .= '</div>';
            $output .= '<p>' . esc_html($trimmed_content)  . '...</p>';
            $output .= '<a href="' . get_permalink() . '" class="card-link">Lees meer</a>';
            $output .= '</div>'; // End of card body
            $output .= '</div>'; // End of card
        }
        $output .= '<div class="owl-nav"></div>'; // End of nav
        $output .= '</div>'; // End of carousel
        wp_reset_postdata();
    } else {
        $output = '<p>Geen concerten gevonden</p>';
    }

    return $output;
}
add_shortcode('concert_pastcarousel', 'concert_pastcarousel_shortcode');

function concert_headerdetails_shortcode() {
    global $post;
    $custom_content = '';
    $post_title = isset($post->post_title) ? $post->post_title : '';
    $concert_datum = get_post_meta($post->ID, 'concert_datum', true);
    $concert_locatie = get_post_meta($post->ID, 'concert_locatie', true);
    $concert_date = $concert_datum;

    if (!empty($concert_date)) {
        $formatted_date = date_i18n('j F, Y', strtotime($concert_datum));
        $today = new DateTime();
        $concert = new DateTime($concert_datum);
        $interval = date_diff($today, $concert);
        $days_left = 1 + $interval->format('%a');

        // Format both today and concert date to 'Y-m-d' for comparison
        $todayFormatted = $today->format('Y-m-d');
        $concertFormatted = $concert->format('Y-m-d');

        $custom_content .= '<div class="ConcertDatum">';
        if ($concertFormatted == $todayFormatted) {
            $custom_content .= '<p>U kunt het concert bijwonen op: <b><span class="mobile-line-break"><br> </span>' . esc_html($formatted_date) . '</b> <br>Het concert is <b>Vandaag.</b></p>';
        } elseif ($concert < $today) {
            $custom_content .= '<p>U had het concert kunnen bijwonen op: <b><span class="mobile-line-break"><br> </span>' . esc_html($formatted_date) . '</b> <br>Het concert is <b>al geweest.</b></p>';
        } elseif ($days_left == 1) {
            $custom_content .= '<p>U kunt het concert bijwonen op: <b><span class="mobile-line-break"><br> </span>' . esc_html($formatted_date) . '</b> <br>Nog <b>' . esc_html($days_left) . '</b> dag te gaan!</p>';
        } elseif ($days_left > 1 && ($concert > $today)) {
            $custom_content .= '<p>U kunt het concert bijwonen op: <b><span class="mobile-line-break"><br> </span>' . esc_html($formatted_date) . '</b> <br>Nog <b>' . esc_html($days_left) . '</b> dagen te gaan!</p>';
        }
        if (!empty($concert_locatie)) {
            $custom_content .= '<p>Locatie: ' . esc_html($concert_locatie) . '</p>';
        }
        $custom_content .= '</div>'; // Sluit de ConcertDatum div

        // Kalender toevoegen
        $custom_content .= '<div class="calendar"><add-to-calendar-button name="Concordia: ' . esc_html($post_title) . '" description="' . get_the_permalink() . '" startDate="' . esc_html(date('Y-m-d', strtotime($concert_datum))) . '" timeZone="Europe/Amsterdam" options="\'Apple\',\'Google\',\'iCal\',\'Outlook.com\',\'Yahoo\',\'Microsoft365\'" hideIconButton hideIconModal hideCheckmark size="5" language="nl"></add-to-calendar-button></div>';
    }

    return $custom_content; // Return de custom content voor de shortcode
}

add_shortcode('concert_headerdetails', 'concert_headerdetails_shortcode');
