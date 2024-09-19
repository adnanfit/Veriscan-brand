<?php
/*
 * Plugin Name:       Veriscan Code Scan
 * Description:       Universal VeriScan: To implement the plugin, use this shortcode: [veriscan_code].
 * Version:           1.3.5
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            M Adnan Ajmal
 * Author URI:        https://www.linkedin.com/in/adi18f/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       veriscan-code-scan
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue necessary scripts and styles
function veriscan_enqueue_scripts() {
    wp_enqueue_style('veriscan-styles', plugin_dir_url(__FILE__) . 'assets/css/form-styles.css');
    wp_enqueue_script('veriscan-ajax', plugin_dir_url(__FILE__) . 'assets/js/veriscan-ajax.js', array('jquery'), null, true);
    
    // Pass AJAX URL to script
    wp_localize_script('veriscan-ajax', 'veriscan_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_endpoint' => get_option('veriscan_api_endpoint'),
        'pluginUrl' => plugin_dir_url(__FILE__)

    ));
}
add_action('wp_enqueue_scripts', 'veriscan_enqueue_scripts');

function veriscan_enqueue_admin_scripts() {
    // Enqueue Bootstrap CSS and JS for admin pages
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'veriscan_enqueue_admin_scripts');

// Include other necessary files
include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcode-handler.php';


// Register shortcode
add_shortcode('veriscan_code', 'veriscan_render_form');