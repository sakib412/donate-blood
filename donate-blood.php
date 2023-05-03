<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Donate Blood
 * Plugin URI:        https://github.com/sakib412/donate-blood
 * Description:       Create a form for blood donation
 * Version:           1.0.0
 * Author:            Najmus Sakib
 * Author URI:        https://github.com/sakib412
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       donate-blood
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('DONATE_BLOOD_VERSION', '1.0.0');

function activate_donate_blood()
{
    require_once plugin_dir_path(__FILE__) . 'includes/activator.php';
    donate_blood_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-donate-blood-deactivator.php
 */
function deactivate_donate_blood()
{
    require_once plugin_dir_path(__FILE__) . 'includes/deactivator.php';
    donate_blood_deactivate();
}

register_activation_hook(__FILE__, 'activate_donate_blood');
register_deactivation_hook(__FILE__, 'deactivate_donate_blood');



function donate_blood_post_type()
{
    // Create donor post type
    register_post_type('donate_blood_donor', array(
        "labels" => array(
            "name" => "Donors",
            "singular_name" => "Donor",
        ),
        "show_in_menu" => true,
        "public" => true,
        "menu_icon" => "dashicons-heart",
        "supports" => [
            "title" => array(
                "label" => "Name",
                "placeholder" => "Enter your name"
            ),
            "editor",
            "thumbnail",
            "custom_fields",
            array(
                'my_feature', array(
                    'field' => 'value'
                )
            )
        ],

    ));
}


add_action("init", "donate_blood_post_type");





// Add Custom Meta Field
function custom_meta_field()
{
    add_meta_box('donate_blood_donor', 'Custom Meta Field', 'custom_meta_field_callback', 'donate_blood_donor');
}
add_action('add_meta_boxes', 'custom_meta_field');

// Callback Function to Display Custom Meta Field
function custom_meta_field_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'custom_meta_box_nonce');
    $value = get_post_meta($post->ID, '_custom_meta_field', true);
    echo '<label for="custom_meta_field">Custom Meta Field</label>';
    echo '<input type="text" id="custom_meta_field" name="custom_meta_field" value="' . esc_attr($value) . '">';
}

// Save Custom Meta Field
function save_custom_meta_field($post_id)
{
    if (!isset($_POST['custom_meta_box_nonce'])) {
        return $post_id;
    }
    $nonce = $_POST['custom_meta_box_nonce'];
    if (!wp_verify_nonce($nonce, basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('donate_blood_donor' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }
    $custom_meta_field = sanitize_text_field($_POST['custom_meta_field']);
    update_post_meta($post_id, '_custom_meta_field', $custom_meta_field);
}
add_action('save_post', 'save_custom_meta_field');
