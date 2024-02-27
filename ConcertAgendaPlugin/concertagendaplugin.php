<?php
/**
 * @link              http://janvgestel.nl
 * @since             1.0.0
 * @package           ConcertagendaPlugin
 * @wordpress-plugin 
 * Plugin Name: Concert Agenda Plugin
 * Description: Een plugin om de concert agenda aan te vullen en voor de display & singlepost display.
 * Version: V1.6
 * Author: Jan van Gestel
 * Author URI: https://janvgestel.nl
 */

 // Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';
require_once plugin_dir_path(__FILE__) . 'includes/uninstall.php';
require_once plugin_dir_path(__FILE__) . 'includes/adminsetting.php';

add_action('init', 'register_concert_post_type');
function register_concert_post_type() {
    register_post_type('concert', array(
        'labels' => array(
            'name' => __('Concerten'),
            'singular_name' => __('Concert')
        ),
        'public' => true,
        'has_archive' => true,
        // 'show_in_rest'  => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-tickets-alt', // Using a dashicon for the menu icon
    ));

    register_taxonomy('concert_status', 'concert', array(
        'labels' => array(
            'name' => __('Concert Status'),
            'singular_name' => __('Concert Status'),
            'search_items' => __('Search Concert Status'),
            'all_items' => __('All Concert Statuses'),
            'edit_item' => __('Edit Concert Status'),
            'update_item' => __('Update Concert Status'),
            'add_new_item' => __('Add New Concert Status'),
            'new_item_name' => __('New Concert Status Name'),
            'menu_name' => __('Concert Status'),
        ),
        'hierarchical' => true, // Like categories
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ));
    

    if (!term_exists('Is geweest', 'concert_status')) {
        wp_insert_term('Is geweest', 'concert_status');
    }
    if (!term_exists('Nog niet geweest', 'concert_status')) {
        wp_insert_term('Nog niet geweest', 'concert_status');
    }
}

add_action('add_meta_boxes', 'add_concert_metaboxes');

function add_concert_metaboxes() {
    add_meta_box('concert_details', 'Concert Details', 'concert_details_callback', 'concert', 'side', 'default');
}

function concert_details_callback($post) {
    wp_nonce_field(basename(__FILE__), 'concert_nonce');
    $concert_datum = get_post_meta($post->ID, 'concert_datum', true);
    $concert_locatie = get_post_meta($post->ID, 'concert_locatie', true);

    echo '<label for="concert_datum">Concert Datum:</label>';
    echo '<input type="date" id="concert_datum" name="concert_datum" value="'. esc_attr($concert_datum) .'" size="25" />';
    
    echo '<label for="concert_locatie">Concert locatie:</label>';
    echo '<input type="text" id="concert_locatie" name="concert_locatie" value="'. esc_attr($concert_locatie) .'" size="25" />';
}

add_action('save_post', 'save_concert_details');

function save_concert_details($post_id) {
    if (!isset($_POST['concert_nonce']) || !wp_verify_nonce($_POST['concert_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['concert_datum'])) {
        update_post_meta($post_id, 'concert_datum', sanitize_text_field($_POST['concert_datum']));
    }

    if (isset($_POST['concert_locatie'])) {
        update_post_meta($post_id, 'concert_locatie', sanitize_text_field($_POST['concert_locatie']));
    }
}

function get_concert_details($post_id) {
    $concert_datum = get_post_meta($post_id, 'concert_datum', true);
    $concert_locatie = get_post_meta($post_id, 'concert_locatie', true);

    if (!empty($concert_datum) || !empty($concert_locatie)) {
        echo '<div class="concert-details">';
        if (!empty($concert_datum)) {
            echo '<p>Concert Date: ' . esc_html($concert_datum) . '</p>';
        }
        if (!empty($concert_locatie)) {
            echo '<p>Concert locatie: ' . esc_html($concert_locatie) . '</p>';
        }
        echo '</div>';
    }
}


function concert_enqueue_scripts($hook) {
    // if ('settings_page_concert-settings' != $hook) {
    //     return;
    // }
    wp_enqueue_media();
    wp_enqueue_script('concert-admin-script', plugin_dir_url(__FILE__) . 'admin/js/concert-admin.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'concert_enqueue_scripts');
