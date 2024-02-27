<?php
 // Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

function concert_agenda_uninstall() {
    // Get all concert posts
    $concerts = get_posts(array(
        'post_type' => 'concert',
        'numberposts' => -1,
        'fields' => 'ids', // Only get post IDs
    ));

    // Remove concert meta data
    foreach ($concerts as $concert_id) {
        delete_post_meta($concert_id, 'concert_datum');
        delete_post_meta($concert_id, 'concert_locatie');
    }

    // Remove all concert posts
    foreach ($concerts as $concert_id) {
        wp_delete_post($concert_id, true);
    }

    // Remove concert_status taxonomy terms
    $terms = get_terms(array(
        'taxonomy' => 'concert_status',
        'hide_empty' => false,
    ));

    foreach ($terms as $term) {
        wp_delete_term($term->term_id, 'concert_status');
    }
}

// register_uninstall_hook(__FILE__, 'concert_agenda_uninstall');

