<?php
// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}
function concert_register_settings() {
    add_option('concert_fallback_image', ''); // Default value for the fallback image URL
    register_setting('concert_options_group', 'concert_fallback_image', 'concert_callback');
}
add_action('admin_init', 'concert_register_settings');

function concert_options_page() {
    add_submenu_page(
        'edit.php?post_type=concert', // Parent slug
        'Concert Settings', // Page title
        'Concert Settings', // Menu title
        'manage_options', // Capability
        'concert-settings', // Menu slug
        'concert_options_page_html' // Callback function
    );
}
add_action('admin_menu', 'concert_options_page');


function concert_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('concert_options_group');
            do_settings_sections('concert-settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Fallback Image</th>
                    <td>
                        <input type="text" id="concert_fallback_image" name="concert_fallback_image" value="<?php echo get_option('concert_fallback_image'); ?>" />
                        <input type="button" class="button concert-upload-button" value="Upload Image" />
                        <p class="description">Upload an image to use as the fallback for concert posts.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
