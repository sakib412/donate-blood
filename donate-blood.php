<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Donate Blood
 * Plugin URI:        https://github.com/sakib412/donate-blood
 * Description:       Create a form for blood donation
 * Version:           0.0.1
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
